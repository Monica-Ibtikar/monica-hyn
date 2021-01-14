<?php

namespace App\Models\Tenant\Passport;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

class PersonalAccessClient extends PassportPersonalAccessClient
{
    use UsesTenantConnection;
}
