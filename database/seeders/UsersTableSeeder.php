<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Agency Admin',
                'email' => 'admin@agency.com',
                'password' => bcrypt('password'),
                'role' => 'agency-admin'
            ],
            [
                'name' => 'Judiciary Admin',
                'email' => 'admin@judiciary.com',
                'password' => bcrypt('password'),
                'role' => 'judiciary-admin'
            ],
            [
                'name' => 'Investigator One',
                'email' => 'investigator1@agency.com',
                'password' => bcrypt('password'),
                'role' => 'investigator'
            ],
            [
                'name' => 'Investigator Two',
                'email' => 'investigator2@agency.com',
                'password' => bcrypt('password'),
                'role' => 'investigator'
            ],
            [
                'name' => 'Judiciary Officer One',
                'email' => 'jOfficer1@judiciary.com',
                'password' => bcrypt('password'),
                'role' => 'judiciary-officer'
            ],
            [
                'name' => 'Judiciary Officer Two',
                'email' => 'jOfficer2@judiciary.com',
                'password' => bcrypt('password'),
                'role' => 'judiciary-officer'
            ]
        ];

        collect($users)->each(fn($user) => User::create($user));
    }
}
