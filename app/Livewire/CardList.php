<?php

namespace App\Livewire;

use Livewire\Component;

class CardList extends Component
{
    public $rand = "";
    public $cards;
    public function mount() {
        $this->rand = rand();
        $orders = auth()->user()->orders;
        foreach($orders as $order) {
            $orderDetails = $order->orderDetails;
            foreach($orderDetails as $detail) {
                $this->cards[] = $detail->bingoCard;
            }
        }
    }

    public function render()
    {
        return view('livewire.card-list');
    }
}
