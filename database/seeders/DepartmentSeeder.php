<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Software Engineering',
            'Computer Engineering',
            'Bio Engineering',
            'Chemical Engineering',
            'Industrial Engineering'
        ];

        foreach ($departments as $dep)
        {
            Department::updateOrCreate([
                'name' => $dep,
                'slug' => Str::slug($dep)
            ]);
        }
    }
}
