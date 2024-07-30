<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Orders;
use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Builder;

class SellerOrderList extends Component
{
    use WithPagination;
    public $cardFilter = '';
    public $nameFilter = '';
    public $totalCards = 0;
    public $totalPrice = 0;

    public function mount() {
        $totalOrder = Orders::where('seller_id', auth()->user()->id)
            ->selectRaw("SUM(quantity) as totalQuantity, SUM(price) as totalPrice")->first();

        if(!empty($totalOrder)) {
            $this->totalCards = $totalOrder->totalQuantity ? $totalOrder->totalQuantity : 0;
            $this->totalPrice = $totalOrder->totalPrice ? $totalOrder->totalPrice : 0;
        }
    }

    public function updated() {
        $this->resetPage();
    }

    public function filterOrders() {
        $this->resetPage();
    }

    public function render()
    {
        $orders = Orders::where('seller_id', auth()->user()->id);
        if (!empty($this->cardFilter)) {
            $orders = $orders->whereHas('orderDetails', function (Builder $query) {
                $query->whereHas('bingoCard', function (Builder $query) {
                    $query->where('card_number', 'like', "%" . $this->cardFilter . "%");
                });
            });
        }

        if (!empty($this->nameFilter)) {
            $orders = $orders->whereHas('user', function (Builder $query) {
                $query->whereRaw("UPPER(name) LIKE '%" . strtoupper($this->nameFilter) . "%'");
            });
        }

        $orders = $orders->paginate(10);

        return view('livewire.seller.seller-order-list', ['orders' => $orders])->layout('layouts.admin');
    }
}
