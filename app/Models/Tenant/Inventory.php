<?php

namespace App\Models\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use UsesTenantConnection;

    protected $fillable = ["available", "pending"];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
