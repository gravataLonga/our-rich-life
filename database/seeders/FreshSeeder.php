<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FreshSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        User::create([
            'name' => 'admin',
            'email' => 'me@jonathan.pt',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);


    }
}
