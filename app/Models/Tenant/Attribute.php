<?php

namespace App\Models\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use UsesTenantConnection;

    protected $guarded = [];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['variations'];

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }
}
