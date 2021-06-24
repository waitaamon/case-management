<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Builder};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class LegalCase extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'public_sector_id', 'investigator_id', 'judicial_officer_id', 'status', 'is_published'];

    public function publicSector(): BelongsTo
    {
        return $this->belongsTo(PublicSector::class);
    }

    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'investigator_id');
    }

    public function judicialOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'judicial_officer_id');
    }

    public function systemEvents(): BelongsToMany
    {
        return $this->belongsToMany(SystemEvent::class, 'case_system_event');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
