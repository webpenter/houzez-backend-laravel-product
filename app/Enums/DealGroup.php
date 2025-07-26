<?php

namespace App\Enums;

/**
 * Enum representing the status of a deal in the CRM system.
 */
enum DealGroup: string
{
    /** The deal is currently active. */
    case ACTIVE = 'active';

    /** The deal has been successfully won. */
    case WON = 'won';

    /** The deal was lost or not pursued. */
    case LOST = 'lost';
}
