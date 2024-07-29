<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class SellerUserList extends Component
{
    use WithPagination;

    public function render()
    {
        $users = User::doesntHave('roles')->paginate(10);

        return view('livewire.seller.seller-user-list', ['users' => $users])->layout('layouts.admin');
    }
}
