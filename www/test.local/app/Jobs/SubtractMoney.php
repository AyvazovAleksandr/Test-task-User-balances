<?php

namespace App\Jobs;

use App\Models\Balance;
use App\Models\Currency;
use App\Models\Operation;
use App\Models\User;
use App\Traits\GlobalMoneyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Money\Money;

class SubtractMoney implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalMoneyTrait;

    private Money $payment;

    private User $user;

    private Currency $currency;

    private string $description;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        Currency $currency,
        Money $payment,
        string $description,
    )
    {
        $this->user = $user;
        $this->currency = $currency;
        $this->payment = $payment;
        $this->description = $description;
        $this->onQueue('money');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $balance = $this->user->balance;
        $balanceAmount = $this->createMoneyObject(
            amount: $balance->amount,
            moneyCurrency: $this->currency->iso_code_str
        );
        if ($this->payment->greaterThan($balanceAmount)) {
            return;
        }
        Operation::create([
            'user_id' => $this->user->id,
            'amount' => $this->getMoneyDecimalFormat($this->payment),
            'type' => 'subtract',
            'currency_id' => $this->currency->id,
            'description' => $this->description,
        ]);
        $balanceAmount = $balanceAmount->subtract(
            $this->payment
        );
        $balance->amount = $this->getMoneyDecimalFormat($balanceAmount);
        $balance->save();
    }
}
