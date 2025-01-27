<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod
{
    public static function all()
    {
        return [
            ['value' => 'card', 'name' => 'クレジットカード'],
            ['value' => 'customer_balance', 'name' => '銀行振込'],
            ['value' => 'konbini', 'name' => 'コンビニ'],
        ];
    }
}
