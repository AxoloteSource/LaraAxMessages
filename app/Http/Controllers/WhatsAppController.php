<?php

namespace App\Http\Controllers;

use App\Data\Messages\SendWhatsAppMessageData;
use App\Logics\Messages\SendWhatsAppMessageLogic;

class WhatsAppController extends Controller
{
    public function send(
        SendWhatsAppMessageData $request,
        SendWhatsAppMessageLogic $logic
    ) {
        $input = $request;
        $result = $logic->run($input);

        return $result;
    }
}
