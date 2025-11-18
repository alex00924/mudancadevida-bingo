<?php

namespace App\Livewire\Seller;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\BingoCards;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class ManualOrder extends Component
{
    public string $name = '';
    public string $city = '';
    public string $phone = '';
    public int $quantity = 1;
    public $cardPrice = 10;
    public $isEnabledSelling = true;
    public $minimumPurchaseQuantity = 1;
    
    public function mount(Request $request) {
        $this->cardPrice = \App\Models\SiteSetting::getPrice();
        $this->isEnabledSelling = \App\Models\SiteSetting::isEnabledSelling();
        $this->minimumPurchaseQuantity = \App\Models\SiteSetting::getMinimumPurchaseQuantity();
        $this->quantity = $this->minimumPurchaseQuantity;
    }

    public function orderManually() {
        $this->minimumPurchaseQuantity = \App\Models\SiteSetting::getMinimumPurchaseQuantity();
        // Fetch next n rows from BingoCard after last ordered number
        $lastOrder = OrderDetails::orderBy('id', 'desc')->first();
        $lastId = 0;
        if (!empty($lastOrder)) {
            $lastId = $lastOrder->bingo_card_id;
        }
        $startSelling = \App\Models\SiteSetting::getStartSelling();
        $lastId = max($lastId, $startSelling-1);

        $endSelling = \App\Models\SiteSetting::getEndSelling();

        if ($lastId + $this->quantity > $endSelling) {
            $this->notify('Aguarde o retorno', 'Advertência', 'warning');
            return;
        }

        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'regex:/\([0-9]{2}\) [0-9]{5}-[0-9]{4}/'],
            'city' => ['nullable', 'string', 'max:255'],
            'quantity' => ['required', 'integer', "min:$this->minimumPurchaseQuantity"]
        ];


        $customMessage = [
            'quantity.min' => 'O campo quantidade deve ser pelo menos :min.'
        ];
        $this->validate($rules, $customMessage);

        $user = User::where('phone', $this->phone)->first();
        if (empty($user)) {
            $user = User::create([
                'name' => $this->name ?? '',
                'phone' => $this->phone,
                'email' => $this->phone,
                'password' => Hash::make('123456789'),
                'city' => $this->city ?? ''
            ]);

            event(new Registered($user));
        } else {
            if (empty($user->name)) {
                $user->name = $this->name;
                $user->save();
            } else {
                $this->name = $user->name;
            }

            if (empty($user->city)) {
                $user->city = $this->city;
                $user->save();
            } else {
                $this->city = $user->city;
            }
        }

        $this->createOrder($user->id);

        $this->notify('Ordem criada com sucesso!', 'Sucesso', 'success');
        return redirect()->to('/vendedor/order/list');
    }
    
    private function createOrder($user_id) {
        $newOrder = [
            'user_id' => $user_id,
            'quantity' => $this->quantity,
            'price' => $this->quantity * $this->cardPrice,
            'payment_status' => 1,
            'payment_id' => 'manual-'.$user_id.'-'.time(),
            'seller_id' => auth()->user()->id,
        ];
        
        // Create Orders
        $order = Orders::create($newOrder);

        // Fetch bingo cards according to random/sequential order setting
        $isRandomOrder = \App\Models\SiteSetting::isCardRandomOrder();
        $bingoCards = collect();
        $startSelling = \App\Models\SiteSetting::getStartSelling();
        if ($isRandomOrder) {
            // Fetch random unsold cards with id >= startSelling
            // $soldCardIds = OrderDetails::pluck('bingo_card_id')->toArray();
            // $bingoCards = BingoCards::whereNotIn('id', $soldCardIds)
            //     ->where('id', '>=', $startSelling)
            //     ->inRandomOrder()
            //     ->limit($this->quantity)
            //     ->get();
            $bingoCards = BingoCards::whereNotIn('id', function($query) {
                $query->select('bingo_card_id')->from('order_details');
            })
            ->where('id', '>=', $startSelling)
            ->inRandomOrder()
            ->limit($this->quantity)
            ->get();
        } else {
            // Fetch sequential cards after the largest sold card or startSelling-1
            $soldCardId = OrderDetails::max('bingo_card_id');
            $lastId = max($soldCardId ?? 0, $startSelling-1);
            $bingoCards = BingoCards::where('id', '>', $lastId)
                ->orderBy('id')
                ->limit($this->quantity)
                ->get();
        }

        foreach($bingoCards as $bingoCard) {
            OrderDetails::create([
                'order_id' => $order->id,
                'bingo_card_id' => $bingoCard->id,
                'user_id' => $user_id
            ]);
        }
    }

    public function render()
    {
        return view('livewire.seller.manual-order');
    }
}
