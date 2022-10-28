<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentDetail extends Model
{
    use HasFactory;

    /**
     * Get the card number masked.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function cardNumber(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::mask($value, '*', 0, 8)
        );
    }
}
