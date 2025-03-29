<?php

use Illuminate\Support\Facades\Route;

Route::prefix('messages')
    ->group(public_path('../routes/modules/messages.php'));
