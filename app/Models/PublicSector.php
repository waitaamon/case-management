<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublicSector extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function legalCases(): HasMany
    {
        return $this->hasMany(LegalCase::class);
    }
    public function systemEvents(): HasMany
    {
        return $this->hasMany(SystemEvent::class);
    }

}
