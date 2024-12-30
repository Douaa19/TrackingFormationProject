<?php

namespace App\Enums;

enum NotifyStatus: int
{
    use EnumTrait;

    case SUPER_ADMIN = 1;
    case AGENT       = 2;
    case USER        = 3;
}