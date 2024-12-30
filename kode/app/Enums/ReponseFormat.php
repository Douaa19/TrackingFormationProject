<?php

namespace App\Enums;

enum ReponseFormat: string
{
    use EnumTrait;


    case MINUTE = 'Minute';
    case HOUR   = "Hour";       // 1 hour = 60 minutes
    case DAY    = "Day";      // 1 day = 24 hours * 60 minutes
    case WEEK   = "Week";    // 1 week = 7 days * 24 hours * 60 minutes

}
