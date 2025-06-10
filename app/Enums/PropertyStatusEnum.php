<?php

namespace App\Enums;

enum PropertyStatusEnum: string
{
    case Published = 'published';
    case Pending = 'pending';
    case Expired = 'expired';
    case Draft = 'draft';
    case OnHold = 'on-hold';
    case Disapproved = 'disapproved';
}
