<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class SellerList extends Component
{
    use WithPagination;
    protected $listeners = ['seller:updated' => 'loadData'];

    public function deleteSeller($id) {
        $user = User::find($id);
        if (!empty($user) && $user->hasRole('seller')) {
            $user->delete();
        }

        $this->notify('Excluiu o vendedor', 'Sucesso');
        $this->resetPage();
    }

    public function clearData() {
        User::role('seller')->delete();
        $this->resetPage();
    }

    public function render()
    {
        $users = User::role('seller')->paginate(10);

        return view('livewire.admin.seller-list', ['users' => $users])->layout('layouts.admin');
    }
}
