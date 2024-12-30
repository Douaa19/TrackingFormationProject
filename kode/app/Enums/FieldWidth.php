<?php

namespace App\Enums;

enum FieldWidth: string
{
    use EnumTrait;

    case COL_12      = "100";
    case COL_6       = "50";
    case COL_4       = "33";
    case COL_3       = "25";
 
}