<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OtherAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $otherAdmin = \App\Models\User::factory()->create([
            'name' => 'Ronaldo Correia',
            'email' => 'contato@chapadahost.com.br',
            'password' => Hash::make("Senha134882*")
        ]);

        $otherAdmin->assignRole('admin');
    }
}
