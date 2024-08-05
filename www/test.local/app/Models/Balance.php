<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\GlobalMoneyTrait;

class Balance extends Model
{
    use HasFactory, SoftDeletes, GlobalMoneyTrait;

    protected $fillable = ['user_id', 'amount', 'currency_id'];

    protected $appends = [
        'amount_format',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return Attribute
     */
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
