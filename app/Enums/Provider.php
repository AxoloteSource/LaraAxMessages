<?php

namespace App\Enums;

enum Provider: int
{
    case META = 1;
    case SENDGRID = 2;
    case MAILGUN = 3;
}
