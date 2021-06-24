<?php

namespace Database\Seeders;

use App\Models\PublicSector;
use Illuminate\Database\Seeder;

class PublicSectorTableSeeder extends Seeder
{

    public function run()
    {
        $sectors = ['KRA', 'Nairobi County', 'Ministry of Health'];

        collect($sectors)->each(fn($sector) => PublicSector::create(['name' => $sector]));
    }
}
