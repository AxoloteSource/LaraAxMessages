<?php

use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::prefix('whatsapp')->controller(WhatsAppController::class)->group(function () {
    Route::post('send', 'send');
});
