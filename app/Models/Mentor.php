<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model implements FilamentUser, HasAvatar
{
    use HasFactory;

    protected $fillable = ['name'];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar;
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
}
