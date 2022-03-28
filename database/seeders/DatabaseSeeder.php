<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Schema::disableForeignKeyConstraints();
        \DB::table('roles')->truncate();
        \DB::table('departments')->truncate();
        \DB::table('courses')->truncate();
        \DB::table('time_tables')->truncate();
        \DB::table('users')->truncate();
        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
            CourseSeeder::class,
            UserSeeder::class,
        ]);
        \Schema::enableForeignKeyConstraints();
    }
}
