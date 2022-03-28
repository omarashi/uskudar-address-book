<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatarPath = storage_path('app/public/users');
        \File::deleteDirectory($avatarPath);

        User::updateOrCreate([
            'f_name' => 'Omar',
            'l_name' => 'Alashi',
            'ref_no' => 'Ad-'.Carbon::now()->timestamp,
            'email' => 'admin@addressbook.com',
            'password' => \Hash::make('password'),
            'phone' => '905530001155',
            'role_id' => Role::where('slug', 'admin')->first()->id
        ]);

        User::factory()->count(5)
            ->has(TimeTable::factory()->count(15))
            ->state([
            'role_id' => Role::where('slug', Role::LECTURER)->first()->id,
        ])->create();
    }
}
