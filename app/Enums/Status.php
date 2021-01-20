<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static New()
 * @method static static Completed()
 * @method static static Cancelled()
 */
final class Status extends Enum
{
    const New =   0;
    const Completed =   1;
    const Cancelled = 2;
}
