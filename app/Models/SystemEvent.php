<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use Illuminate\Support\Str;

class SystemEvent extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'public_sector_id', 'host_ip', 'message', 'device_time', 'user', 'sys_log_tag'];

    public static function boot()
    {
        parent::boot();

        static::creating(function (SystemEvent $event) {
            $event->code = Str::uuid();
        });

    }

    public function publicSector(): BelongsTo
    {
        return $this->belongsTo(PublicSector::class);
    }

    public function legaCases(): BelongsToMany
    {
        return $this->belongsToMany(LegalCase::class, 'case_system_event');
    }
}
