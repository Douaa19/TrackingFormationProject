<?php

namespace App\Enums;

enum PriorityStatus: int
{
    use EnumTrait;

    case Urgent  = 1;
    case HIGH    = 2;
    case LOW     = 3;
    case MEDIUM  = 4;
    
}