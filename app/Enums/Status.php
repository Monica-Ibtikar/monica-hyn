<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NEW()
 * @method static static COMPLETED()
 * @method static static CANCELLED()
 */
final class Status extends Enum
{
    const NEW =   0;
    const COMPLETED =   1;
    const CANCELLED = 2;
}
