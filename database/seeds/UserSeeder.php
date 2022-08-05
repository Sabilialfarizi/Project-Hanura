<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Developer',
            'email' => 'admin@localhost.com',
            'password' => Hash::make('admin'),
            'is_active' => 1
        ]);
    }
}
