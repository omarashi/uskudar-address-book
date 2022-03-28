<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin'
            ],
            [
                'name' => 'Human Resources',
                'slug' => 'hr'
            ],
            [
                'name' => 'Lecturer',
                'slug' => 'lecturer'
            ],
            [
                'name' => 'Student',
                'slug' => 'student'
            ]
        ];

        Role::upsert(
            $roles,
            ['name', 'slug'],
            ['name']
        );
    }
}
