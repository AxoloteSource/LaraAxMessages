<?php

namespace App\Data\Messages;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class SendWhatsAppMessageData extends Data
{
    public function __construct(
        #[Rule(['required', 'string'])]
        public string $template_name,
        #[Rule(['required', 'string'])]
        public string $phone_number,
        #[Rule(['required', 'array'])]
        public array $params,
    ) {}
}
