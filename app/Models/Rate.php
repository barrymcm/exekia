<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'hourly', 'user_id', 'currency_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    final public function currency(): HasOne
    {
        return $this->hasOne(Currency::class);
    }
}
