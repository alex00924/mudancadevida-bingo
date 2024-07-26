<?php

namespace App\Models;

use App\Livewire\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function cardNumbers() {
        $orderDetails = $this->orderDetails;

        $cardNumbers = [];
        foreach($orderDetails as $detail) {
            $cardNumbers[] = $detail->bingoCard->card_number . "-" . $detail->bingoCard->card_digit;
        }

        return implode(",", $cardNumbers);
    }

    public function cardDigits() {
        $orderDetails = $this->orderDetails;

        $cardNumbers = [];
        foreach($orderDetails as $detail) {
            $cardNumbers[] = $detail->bingoCard->card_digit;
        }

        return implode(",", $cardNumbers);
    }
}
