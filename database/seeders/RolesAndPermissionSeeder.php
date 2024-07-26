<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'admin']);
        Permission::create(['name' => 'customer']);


        $Admin = Role::create(['name' => 'admin']);
        $Customer = Role::create(['name' => 'customer']);

        $Admin->givePermissionTo(['admin']);
        $Customer->givePermissionTo(['customer']);

        $adminUser = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'bingo_admin@dbilhar.com',
            'password' => Hash::make("bingo_admin")
        ]);

        $adminUser->assignRole('admin');

        $otherAdmin = \App\Models\User::factory()->create([
            'name' => 'Ronaldo Correia',
            'email' => 'contato@chapadahost.com.br',
            'password' => Hash::make("Senha134882*")
        ]);

        $otherAdmin->assignRole('admin');
    }
}
