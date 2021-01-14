<?php

namespace App\Models\Tenant\Passport;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Laravel\Passport\AuthCode as PassportAuthCode;

class AuthCode extends PassportAuthCode
{
    use UsesTenantConnection;
}
