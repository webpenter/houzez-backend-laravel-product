<?php

namespace App\Enums;

enum DealGroup: string
{
    case ACTIVE = 'active';
    case WON = 'won';
    case LOST = 'lost';
}
