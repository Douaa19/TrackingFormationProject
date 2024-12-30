<?php
  
namespace App\Enums;
 
enum TicketReply :int {

    use EnumTrait;
    case STAY_ON_PAGE        = 1;
    case NEXT_TICKET         = 2;
    case TICKET_LIST         = 3;

}