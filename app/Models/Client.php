<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
class Client extends Model 
{

    use HasFactory;
    protected $table = 'clients';
    protected $guarded = false;

    public function updateAllBalance()
    {
        // Вычисляем сумму всех полей amount из таблицы contributions
        $contributionsSum = Contribution::where('client_id', $this->id)->sum('amount');

        // Вычисляем сумму всех полей balance из таблицы cards
        $cardsSum = Card::where('client_id', $this->id)->sum('balance');

        // Обновляем поле AllBalance в текущем экземпляре модели
        $this->update(['AllBalance' => $contributionsSum + $cardsSum]);

        return $this;
    }
    public function getAuthPassword()
    {
        return $this->attributes['Pincode'];
    }

    

}
