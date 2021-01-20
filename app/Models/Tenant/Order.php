<?php

namespace App\Models\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use UsesTenantConnection;

    protected $fillable = ["customer_name", "customer_phone", "total", "status"];

    protected $with = ["products"];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }
}
