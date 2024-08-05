<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GlobalMoneyTrait;

class Operation extends Model
{
    use HasFactory, SoftDeletes, GlobalMoneyTrait;

    protected $table = 'operations';

    protected $fillable = ['user_id', 'amount', 'type', 'currency_id', 'description'];

    protected $appends = [
        'amount_format',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function amount(): Attribute
    {
        //@TODO add $this->currency->exchange_currency
        return Attribute::make(
            get: fn (int $amount) => $amount / 100,
            set: fn (float $amount) => $amount * 100,
        );
    }

    public function getAmountFormatAttribute(): string
    {
        return $this->getMoneyFormatter(
            $this->createMoneyObject(
                amount: $this->amount,
                moneyCurrency: $this->currency->iso_code_str
            )
        );
    }
}
