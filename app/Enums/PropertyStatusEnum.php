<?php

namespace App\Enums;

/**
 * Enum representing the various status values a property listing can have.
 */
enum PropertyStatusEnum: string
{
    /** The property is published and visible to users. */
    case Published = 'published';

    /** The property is pending approval or review. */
    case Pending = 'pending';

    /** The property listing has expired and is no longer active. */
    case Expired = 'expired';

    /** The property is saved as a draft and not yet published. */
    case Draft = 'draft';

    /** The property is temporarily on hold and not publicly visible. */
    case OnHold = 'on-hold';

    /** The property was reviewed and not approved for publication. */
    case Disapproved = 'disapproved';
}
