<?php

namespace App\Models\Tenant\Passport;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Laravel\Passport\RefreshToken as PassportRefreshToken;

class RefreshToken extends PassportRefreshToken
{
    use UsesTenantConnection;
}
