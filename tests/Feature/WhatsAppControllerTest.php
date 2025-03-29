<?php

namespace Tests\Unit\Feature;

use App\Data\Messages\SendWhatsAppMessageData;
use App\Enums\Channel;
use App\Enums\MessageStatus as EnumMessageStatus;
use App\Enums\Provider;
use App\Logics\Messages\SendWhatsAppMessageLogic;
use App\Models\ChannelProvider;
use App\Models\ChannelProviderField;
use App\Models\Field;
use App\Models\Message;
use App\Models\MessageDetails;
use App\Models\MessageHistory;
use App\Models\MessageStatus;
use App\Models\ProviderConfig;
use Axolotesource\LaravelWhatsappApi\WhatsAppMessages\WhatsAppMessages;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Mockery;
use Spatie\LaravelData\Data;
use Tests\TestCase;

class WhatsAppControllerTest extends TestCase
{

    protected $params = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->params = [
            [
                'key' => 'user',
                'value' => fake()->name(),
            ], [
                'key' => 'folio',
                'value' => fake()->numberBetween(1, 1000),
            ], [
                'key' => 'link',
                'value' => fake()->url(),
            ],
            [
                'key' => 'additional_info',
                'value' => fake()->text(25),
            ],
        ];

        $this->seed([
            \Database\Seeders\FieldTypesSeeder::class,
            \Database\Seeders\FieldSeeder::class,
            \Database\Seeders\ChannelSeeder::class,
            \Database\Seeders\ProviderSeeder::class,
            \Database\Seeders\MessageStatusSeeder::class,
            \Database\Seeders\ChannelProviderSeeder::class,
            \Database\Seeders\ProviderConfigSeeder::class,
        ]);
    }

    public function test_run_success()
    {
        $channelProvider = ChannelProvider::first();
        $messageStatus = MessageStatus::first();
        $channelProviderField = ChannelProviderField::first();

        $data = new SendWhatsAppMessageData(
            template_name: 'pruebas_solicitud_inicio',
            phone_number: '523121280504',
            params: $this->params
        );

        $mockWhatsAppMessages = Mockery::mock(WhatsAppMessages::class);
        $mockWhatsAppMessages->shouldReceive('templete')
            ->with('523121280504', 'pruebas_solicitud_inicio')
            ->andReturnSelf();
        $mockWhatsAppMessages->shouldReceive('language')
            ->with('es')
            ->andReturnSelf();
        $mockWhatsAppMessages->shouldReceive('addComponents')
            ->andReturnSelf();
        $mockWhatsAppMessages->shouldReceive('send')
            ->andReturn(collect(['status' => 'success']));

        $logic = new SendWhatsAppMessageLogic(
            $this->app->make(ProviderConfig::class),
            $this->app->make(Message::class),
            $this->app->make(MessageStatus::class),
            $this->app->make(MessageHistory::class),
            $this->app->make(MessageDetails::class),
            $this->app->make(ChannelProviderField::class),
            $mockWhatsAppMessages
        );

        $result = $logic->run($data);

        $this->assertDatabaseHas('messages', [
            'channel_provider_id' => $channelProvider->id,
            'message_status_id' => $messageStatus->id,
            'attempts' => 0,
        ]);

        $this->assertDatabaseHas('message_histories', [
            'message_status_id' => $messageStatus->id,
        ]);

        $this->assertDatabaseHas('message_details', [
            'channel_provider_field_id' => $channelProviderField->id,
            'value' => 'pruebas_solicitud_inicio',
        ]);

        $this->assertDatabaseHas('message_details', [
            'channel_provider_field_id' => $channelProviderField->id + 1,
            'value' => '523121280504',
        ]);

        $this->assertDatabaseHas('message_details', [
            'channel_provider_field_id' => $channelProviderField->id + 2,
            'value' => json_encode($this->params),
        ]);

        $this->assertNotNull($result);
        $this->assertEquals(201, $result->getStatusCode());
    }

    public function test_before_fails_when_credentials_not_found()
    {
        ProviderConfig::truncate();
        $data = new SendWhatsAppMessageData(
            template_name: 'pruebas_solicitud_inicio',
            phone_number: '523121280504',
            params: $this->params
        );

        $logic = new SendWhatsAppMessageLogic(
            $this->app->make(ProviderConfig::class),
            $this->app->make(Message::class),
            $this->app->make(MessageStatus::class),
            $this->app->make(MessageHistory::class),
            $this->app->make(MessageDetails::class),
            $this->app->make(ChannelProviderField::class),
            Mockery::mock(WhatsAppMessages::class)
        );

        $result = $logic->run($data);

        $this->assertFalse($logic->before());
        $this->assertEquals(400, $result->getStatusCode());
        $this->assertStringContainsString('messages.sendWhatsAppMessage.failedToGetCredentials', $result->getData()->message);
    }

    // public function test_before_fails_when_channel_provider_fields_not_found()
    // {
    //     $this->refreshDatabase();
    //     ChannelProviderField::truncate();

    //     $data = new SendWhatsAppMessageData(
    //         template_name: 'pruebas_solicitud_inicio',
    //         phone_number: '523121280504',
    //         params: [$this->params]
    //     );

    //     $logic = new SendWhatsAppMessageLogic(
    //         $this->app->make(ProviderConfig::class),
    //         $this->app->make(Message::class),
    //         $this->app->make(MessageStatus::class),
    //         $this->app->make(MessageHistory::class),
    //         $this->app->make(MessageDetails::class),
    //         $this->app->make(ChannelProviderField::class),
    //         Mockery::mock(WhatsAppMessages::class)
    //     );

    //     $result = $logic->run($data);

    //     $this->assertFalse($logic->before());
    //     $this->assertEquals(400, $result->getStatusCode());
    //     $this->assertStringContainsString('messages.sendWhatsAppMessage.failedToGetChannelProviderFields', $result->getData()->message);

    //     $this->refreshDatabase();
    // }

    // public function test_before_fails_when_required_fields_are_missing()
    // {
    //     $data = new SendWhatsAppMessageData(
    //         template_name: '',
    //         phone_number: '',
    //         params: []
    //     );

    //     $logic = new SendWhatsAppMessageLogic(
    //         $this->app->make(ProviderConfig::class),
    //         $this->app->make(Message::class),
    //         $this->app->make(MessageStatus::class),
    //         $this->app->make(MessageHistory::class),
    //         $this->app->make(MessageDetails::class),
    //         $this->app->make(ChannelProviderField::class),
    //         Mockery::mock(WhatsAppMessages::class)
    //     );

    //     $result = $logic->run($data);

    //     $this->assertFalse($logic->before());
    //     $this->assertEquals(400, $result->getStatusCode());
    //     $this->assertStringContainsString('messages.sendWhatsAppMessage.someParamsAreRequired', $result->getData()->error);
    // }

    // public function test_after_fails_when_message_histories_cannot_be_created()
    // {
    //     $providerConfig = ProviderConfig::first();
    //     $channelProvider = ChannelProvider::first();
    //     $messageStatus = MessageStatus::first();
    //     $channelProviderField = ChannelProviderField::first();
    //     $field = Field::first();

    //     $data = new SendWhatsAppMessageData(
    //         template_name: 'test_template',
    //         phone_number: '523121280504',
    //         params: [['value' => 'test_param']]
    //     );

    //     $mockWhatsAppMessages = Mockery::mock(WhatsAppMessages::class);
    //     $mockWhatsAppMessages->shouldReceive('templete')
    //         ->with('523121280504', 'test_template')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('language')
    //         ->with('es')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('addComponents')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('send')
    //         ->andReturn(collect(['status' => 'success']));

    //     $logic = new SendWhatsAppMessageLogic(
    //         $this->app->make(ProviderConfig::class),
    //         $this->app->make(Message::class),
    //         $this->app->make(MessageStatus::class),
    //         Mockery::mock(MessageHistory::class)->shouldReceive('createMany')->andReturn(new Collection())->getMock(),
    //         $this->app->make(MessageDetails::class),
    //         $this->app->make(ChannelProviderField::class),
    //         $mockWhatsAppMessages
    //     );

    //     $result = $logic->run($data);

    //     $this->assertFalse($logic->after());
    //     $this->assertEquals(400, $result->getStatusCode());
    //     $this->assertStringContainsString('messages.sendWhatsAppMessage.failedToCreateMessageHistories', $result->getData()->error);
    // }

    // public function test_after_fails_when_message_details_cannot_be_created()
    // {
    //     $providerConfig = ProviderConfig::first();
    //     $channelProvider = ChannelProvider::first();
    //     $messageStatus = MessageStatus::first();
    //     $channelProviderField = ChannelProviderField::first();
    //     $field = Field::first();

    //     $data = new SendWhatsAppMessageData(
    //         template_name: 'test_template',
    //         phone_number: '523121280504',
    //         params: [['value' => 'test_param']]
    //     );

    //     $mockWhatsAppMessages = Mockery::mock(WhatsAppMessages::class);
    //     $mockWhatsAppMessages->shouldReceive('templete')
    //         ->with('523121280504', 'test_template')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('language')
    //         ->with('es')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('addComponents')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('send')
    //         ->andReturn(collect(['status' => 'success']));

    //     $logic = new SendWhatsAppMessageLogic(
    //         $this->app->make(ProviderConfig::class),
    //         $this->app->make(Message::class),
    //         $this->app->make(MessageStatus::class),
    //         $this->app->make(MessageHistory::class),
    //         Mockery::mock(MessageDetails::class)->shouldReceive('createMany')->andReturn(new Collection())->getMock(),
    //         $this->app->make(ChannelProviderField::class),
    //         $mockWhatsAppMessages
    //     );

    //     $result = $logic->run($data);

    //     $this->assertFalse($logic->after());
    //     $this->assertEquals(400, $result->getStatusCode());
    //     $this->assertStringContainsString('messages.sendWhatsAppMessage.failedToCreateMessageDetails', $result->getData()->error);
    // }

    // public function test_send_message_fails()
    // {
    //     $providerConfig = ProviderConfig::first();
    //     $channelProvider = ChannelProvider::first();
    //     $messageStatus = MessageStatus::first();
    //     $channelProviderField = ChannelProviderField::first();
    //     $field = Field::first();

    //     $data = new SendWhatsAppMessageData(
    //         template_name: 'test_template',
    //         phone_number: '523121280504',
    //         params: [['value' => 'test_param']]
    //     );

    //     $mockWhatsAppMessages = Mockery::mock(WhatsAppMessages::class);
    //     $mockWhatsAppMessages->shouldReceive('templete')
    //         ->with('523121280504', 'test_template')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('language')
    //         ->with('es')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('addComponents')
    //         ->andReturnSelf();
    //     $mockWhatsAppMessages->shouldReceive('send')
    //         ->andReturn(collect(['error' => ['message' => 'test_error', 'code' => 123, 'error_data' => []]]));

    //     $logic = new SendWhatsAppMessageLogic(
    //         $this->app->make(ProviderConfig::class),
    //         $this->app->make(Message::class),
    //         $this->app->make(MessageStatus::class),
    //         $this->app->make(MessageHistory::class),
    //         $this->app->make(MessageDetails::class),
    //         $this->app->make(ChannelProviderField::class),
    //         $mockWhatsAppMessages
    //     );

    //     $result = $logic->run($data);

    //     $this->assertFalse($logic->sendMessage());
    //     $this->assertEquals(400, $result->getStatusCode());
    //     $this->assertStringContainsString('messages.sendWhatsAppMessage.sendWhatsAppMessageUnknownError', $result->getData()->error);
    // }
}
