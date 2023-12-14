<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = false;
    protected $table ='transactions';
    use HasFactory;
    public function senderCard()
    {
        return $this->belongsTo(Card::class, 'sender_card_id');
    }

    // Определение отношения с картой получателя
    public function receiverCard()
    {
        return $this->belongsTo(Card::class, 'receiver_card_id');
    }
}
