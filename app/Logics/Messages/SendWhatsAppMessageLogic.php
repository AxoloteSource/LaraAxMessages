<?php

namespace App\Logics\Messages;

use App\Core\Logics\StoreLogic;
use App\Enums\Channel;
use App\Enums\MessageStatus as EnumMessageStatus;
use App\Enums\Provider;
use App\Models\ChannelProviderField;
use App\Models\Message;
use App\Models\MessageDetails;
use App\Models\MessageHistory;
use App\Models\MessageStatus;
use App\Models\ProviderConfig;
use Axolotesource\LaravelWhatsappApi\WhatsAppMessages\Messages\Templates\Components\BodyComponent;
use Axolotesource\LaravelWhatsappApi\WhatsAppMessages\Messages\Templates\Components\Params;
use Axolotesource\LaravelWhatsappApi\WhatsAppMessages\WhatsAppMessages;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Spatie\LaravelData\Data;

final class SendWhatsAppMessageLogic extends StoreLogic
{
    protected $channelProviderField = null;

    protected $errorCodeBase = 'messages.sendWhatsAppMessage';

    public function __construct(
        protected ProviderConfig $providerConfigs,
        protected Message $messages,
        protected MessageStatus $messageStatuses,
        protected MessageHistory $messageHistories,
        protected MessageDetails $messageDetails,
        protected ChannelProviderField $channelProviderFields,
        protected WhatsAppMessages $whatsAppMessages
    ) {
        parent::__construct($messages);
    }

    public function run(Data $input): JsonResponse
    {
        return parent::logic($input);
    }

    public function before(): bool
    {
        $providerConfigs = $this->getCredentials();
        if (! $providerConfigs) {
            return false;
        }

        $config = is_array($providerConfigs->config) ? $providerConfigs->config : json_decode($providerConfigs->config, true);
        $this->setCredentials($config);

        $channelProviderFields = $this->getChannelProviderFields($providerConfigs->channel_provider_id);
        if (! $channelProviderFields) {
            return false;
        }

        $fieldsAreValid = $this->fieldsAreValid($channelProviderFields);
        if (! $fieldsAreValid) {
            return false;
        }

        $this->channelProviderField = $channelProviderFields;

        return true;
    }

    public function action(): self
    {
        $initialStatus = $this->messageStatuses->find(EnumMessageStatus::PROCESSING);
        $channelProviderId = $this->channelProviderField->first()?->channel_provider_id;

        $message = $this->model->create([
            'channel_provider_id' => $channelProviderId,
            'created_user_id' => 'pending',
            'message_status_id' => $initialStatus->id,
            'attempts' => 0,
        ]);

        $this->response = $message;

        return $this;
    }

    public function after(): bool
    {
        $message = $this->response;

        $messageHistories = $this->createMessageHistories($message);

        if (! $messageHistories) {
            return false;
        }

        $messageDetails = $this->createMessageDetails($message);
        if (! $messageDetails) {
            return false;
        }

        $sendMessage = $this->sendMessage();
        if (! $sendMessage) {
            return false;
        }

        return true;
    }

    private function getCredentials(): ProviderConfig|false
    {
        $providerConfigs = $this->providerConfigs->getDefaultConfigWithChannelProviderByChannelAndProvider(
            Channel::WHATSAPP->value,
            Provider::META->value,
        );

        if ($providerConfigs) {
            return $providerConfigs;
        }

        return $this->error("$this->errorCodeBase.failedToGetCredentials", [
            'channel_id' => Channel::WHATSAPP->value,
            'provider_id' => Provider::META->value,
        ]);
    }

    private function setCredentials(array $configs): void
    {
        collect($configs)->each(function ($value, $key) {
            $key = substr($key, 18);
            try {
                $value = Crypt::decrypt($value);
            } catch (DecryptException $e) {
                $value = $value;
            }
            config(["laravel-whatsapp-api.$key" => $value]);
        });
    }

    private function getChannelProviderFields(
        int $channelProviderId
    ): Collection|false {
        $channelProviderFields = $this->channelProviderFields->getByChannelProviderId($channelProviderId);

        if (! $channelProviderFields->isEmpty()) {
            return $channelProviderFields;
        }

        return $this->error("$this->errorCodeBase.failedToGetChannelProviderFields", [
            'channel_provider_id' => $channelProviderId,
        ]);

    }

    private function fieldsAreValid(
        Collection $channelProviderFields
    ): bool {
        $isValid = true;
        $invalidFields = [];

        foreach ($channelProviderFields as $channelProviderField) {
            if (! $channelProviderField->isRequired) {
                continue;
            }

            if (array_key_exists($channelProviderField->field?->name, $this->input)) {
                $isValid = false;
                $invalidFields[] = $channelProviderField->field?->name;
            }
        }

        if ($isValid) {
            return $isValid;
        }

        return $this->error("$this->errorCodeBase.someParamsAreRequired", $invalidFields);
    }

    private function createMessageHistories(
        Message $message
    ): Collection|false {
        $messageHistories = $message->messageHistories()->createMany([
            [
                'message_status_id' => $message->message_status_id,
            ],
        ]);

        if ($message->messageHistories->isEmpty()) {
            return $this->error("$this->errorCodeBase.failedToCreateMessageHistories", [
                'message_id' => $message->id,
                'message_status_id' => $message->message_status_id,
            ]);
        }

        return $messageHistories;
    }

    private function createMessageDetails(
        Message $message
    ): array|false {
        $payload = [];

        foreach ($this->channelProviderField as $channelProviderField) {
            $field = $channelProviderField->field;
            $value = ($field->name === 'params') ? json_encode($this->input->{$field->name}) : $this->input->{$field->name};
            $payload[] = [
                'channel_provider_field_id' => $channelProviderField->id,
                'message_id' => $message->id,
                'value' => $value,
            ];
        }

        $messageDetails = $message->messageDetails()->createMany($payload);

        if ($messageDetails->isEmpty()) {
            return $this->error("$this->errorCodeBase.failedToCreateMessageDetails", [
                $payload,
            ]);
        }

        return $messageDetails->toArray();
    }

    public function sendMessage(): bool
    {
        if (env('APP_ENV') !== 'production') {
            return true;
        }

        $messageBuilder = WhatsAppMessages::templete($this->input->phone_number, $this->input->template_name)
            ->language('es');

        $params = [];
        foreach ($this->input->params as $param) {
            $params[] = Params::text($param['value']);
        }

        $result = $messageBuilder->addComponents([
            BodyComponent::create($params),
        ])->send();

        if ($result->failed()) {
            $error = $result->json();
            $error = array_pop($error);

            return $this->error("$this->errorCodeBase.sendWhatsAppMessageUnknownError", [
                'message' => $error['message'],
                'code' => $error['code'],
                'errors' => $error['error_data'],
            ]);
        }

        return true;
    }
}
