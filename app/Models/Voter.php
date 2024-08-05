<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voter extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address'];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
