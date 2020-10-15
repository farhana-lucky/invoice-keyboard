<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Shourov Shahadat',
            'email' => 'shooorov@gmail.com',
            'password' => bcrypt('shooorov@gmail.com'),
            'email_verified_at' => now(),
        ]);
        factory(App\User::class)->create();
    }
}
