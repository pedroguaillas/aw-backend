<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pedro Guaillas',
            'user' => 'Peter',
            'rol' => 'admin',
            'password' => Hash::make('Peter')
        ]);
    }
}
