<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LegalCaseResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'public_sector_id' => $this->public_sector_id,
            'public_sector' => $this->publicSector,
            'public_sector_name' => $this->publicSector->name,
            'investigator_id' => $this->investigator_id,
            'investigator' => $this->investigator,
            'investigator_name' => optional($this->investigator)->name,
            'judicial_officer_id' => $this->judicial_officer_id,
            'judicial_officer_name' => optional($this->judicialOfficer)->name,
            'judicial_officer' => $this->judicialOfficer,
            'status' => $this->status,
            'is_published' => $this->is_published,
            'system_events' =>  $this->systemEvents
        ];
    }
}
