<?php

namespace App\Models\System;

use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use UsesSystemConnection, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
