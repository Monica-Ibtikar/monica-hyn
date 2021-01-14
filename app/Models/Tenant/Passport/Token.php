<?php

namespace App\Models\Tenant\Passport;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Laravel\Passport\Token as PassportToken;

class Token extends PassportToken
{
    use UsesTenantConnection;
}
