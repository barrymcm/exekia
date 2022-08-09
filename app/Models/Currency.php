<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    final public function rate(): BelongsTo
    {
        return $this->belongsTo(Rate::class);
    }
}
