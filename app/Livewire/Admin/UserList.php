<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserList extends Component
{
    use WithPagination;

    public function clearData() {
        User::doesntHave('roles')->delete();
        // \App\Models\User::truncate();
        \App\Models\OrderDetails::truncate();
        \App\Models\Orders::truncate();

        // $adminUser = \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'bingo_admin@dbilhar.com',
        //     'password' => Hash::make("bingo_admin")
        // ]);

        // $adminUser->assignRole('admin');

        // $otherAdmin = \App\Models\User::factory()->create([
        //     'name' => 'Ronaldo Correia',
        //     'email' => 'contato@chapadahost.com.br',
        //     'password' => Hash::make("Senha134882*")
        // ]);

        // $otherAdmin->assignRole('admin');
        $this->resetPage();
    }

    public function render()
    {
        $users = User::doesntHave('roles')->paginate(10);

        return view('livewire.admin.user-list', ['users' => $users])->layout('layouts.admin');
    }
}
