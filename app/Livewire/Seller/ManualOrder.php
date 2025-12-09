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
    public string $card_number = '';
    public $cardPrice = 10;
    public $isEnabledSelling = true;
    
    public function mount(Request $request) {
        $this->cardPrice = \App\Models\SiteSetting::getPrice();
        $this->isEnabledSelling = \App\Models\SiteSetting::isEnabledSelling();
    }

    public function orderManually() {
        // clear errors
        $this->resetErrorBag();
        $customMessage = [
            'phone.regex' => 'O campo telefone deve estar no formato (99) 99999-9999.',
        ];
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'regex:/\([0-9]{2}\) [0-9]{5}-[0-9]{4}/'],
            'city' => ['nullable', 'string', 'max:255'],
        ];

        $this->validate($rules, $customMessage);

        // check if card_number is exists and not sold
        // split card_number into main part and last digit
        if (strlen($this->card_number) < 2) {
            $this->addError('card_number', 'Número da cartela inválido.');
            return;
        }
        $mainPart = substr($this->card_number, 0, -1);
        $lastDigit = substr($this->card_number, -1);
        $bingoCard = BingoCards::where('card_number', $mainPart)
            ->where('card_digit', $lastDigit)->first();
        if (empty($bingoCard)) {
            $this->addError('card_number', 'Número da cartela inválido.');
            return;
        }
        $isSold = OrderDetails::where('bingo_card_id', $bingoCard->id)->exists();
        if ($isSold) {
            $this->addError('card_number', 'Número da cartela já foi vendido.');
            return;
        }

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

        $this->createOrder($user->id, $bingoCard->id);

        $this->notify('Ordem criada com sucesso!', 'Sucesso', 'success');
        return redirect()->to('/vendedor/order/list');
    }
    
    private function createOrder($user_id, $bingo_card_id) {
        $newOrder = [
            'user_id' => $user_id,
            'quantity' => 1,
            'price' => 1 * $this->cardPrice,
            'payment_status' => 1,
            'payment_id' => 'manual-'.$user_id.'-'.time(),
            'seller_id' => auth()->user()->id,
        ];
        
        // Create Orders
        $order = Orders::create($newOrder);
        OrderDetails::create([
            'order_id' => $order->id,
            'bingo_card_id' => $bingo_card_id,
            'user_id' => $user_id
        ]);
    }

    public function render()
    {
        return view('livewire.seller.manual-order');
    }
}
