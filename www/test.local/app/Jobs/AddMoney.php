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
use Illuminate\Support\Facades\File;
use Money\Money;

class AddMoney implements ShouldQueue
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
        Operation::create([
            'user_id' => $this->user->id,
            'amount' => $this->getMoneyDecimalFormat($this->payment),
            'type' => 'add',
            'currency_id' => $this->currency->id,
            'description' => $this->description,
        ]);

        $balanceAmount = $this->createMoneyObject(
            amount: $balance->amount,
            moneyCurrency: $this->currency->iso_code_str
        );

        $balanceAmount = $balanceAmount->add(
            $this->payment
        );

        $balance->amount = $this->getMoneyDecimalFormat($balanceAmount);
        $balance->save();
    }
}
