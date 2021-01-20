<?php

namespace App\Models\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use UsesTenantConnection, SoftDeletes;

    protected $fillable = ["sku", "name", "image"];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['variations'];

    public function variations()
    {
        return $this->belongsToMany(Variation::class)->withTimestamps();
    }
}
