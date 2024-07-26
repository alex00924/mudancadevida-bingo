<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;
    public function render()
    {
        $orders = auth()->user()->orders()->paginate(10);

        return view('livewire.order-list', ['orders' => $orders]);
    }
}
