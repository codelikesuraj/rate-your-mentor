<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vote extends Model
{
    use HasFactory;

    public function voter(): BelongsTo
    {
        return $this->belongsTo(Voter::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function mentor(): HasOne
    {
        return $this->hasOne(Mentor::class);
    }
}
