<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@super-library.test',
            'level' => 2,
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10)
        ]);

        User::factory()->count(50)->create();
    }
}
