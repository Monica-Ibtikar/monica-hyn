<?php

namespace App\Models\Tenant\Passport;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    use UsesTenantConnection;
}
