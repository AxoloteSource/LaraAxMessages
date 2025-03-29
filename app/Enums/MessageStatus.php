<?php

namespace App\Enums;

enum MessageStatus: int
{
    case PROCESSING = 1;
    case SEND = 2;
    case DELIVERED = 3;
    case NOT_DELIVERED = 4;
}
