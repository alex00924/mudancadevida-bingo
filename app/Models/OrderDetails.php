<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bingoCard() {
        return $this->belongsTo(BingoCards::class, 'bingo_card_id', 'id');
    }

    public function order() {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
