<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Currency;
use App\Models\Operation;
use App\Traits\GlobalMoneyTrait;
use App\Jobs\AddMoney;
use App\Jobs\SubtractMoney;

class AddTransaction extends Command
{

    use GlobalMoneyTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-transaction {email} {type} {amount} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add transaction';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $amount = $this->argument('amount');
        $type = $this->argument('type');
        $description = $this->argument('description');

        $validator = Validator::make([
            'email' => $email,
            'amount' => $amount,
            'type' => $type,
        ], [
            'email' => 'required|email:rfc',
            'amount' => 'required|numeric|min:0.01',
            'type' => Rule::in(['add', 'subtract']),
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
                return self::FAILURE;
            }
        }

        //As a demo mode, we do not give the user a choice of currency
        //United States dollar
        $currency = Currency::find(1);
        if (is_null($currency)) {
            $this->error(__('messages.currency_not_found'));
            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            $this->error(__('messages.user_not_found'));
            return self::FAILURE;
        }

        $balance = $user->balance;

        if ($type == 'add') {
            AddMoney::dispatch(
                $user,
                $currency,
                $this->createMoneyObject(
                    amount: $amount,
                    moneyCurrency: $currency->iso_code_str
                ),
                $description
            );
            $this->info(__('messages.add_transaction'));
            return self::SUCCESS;
        }

        if ($type == 'subtract') {
            $balanceAmount = $this->createMoneyObject(
                amount: $balance->amount,
                moneyCurrency: $currency->iso_code_str
            );
            if ($this->createMoneyObject(
                amount: $amount,
                moneyCurrency: $currency->iso_code_str
            )->greaterThan($balanceAmount)) {
                $this->error(__('messages.no_money_on_the_balance'));
                return self::FAILURE;
            }
            SubtractMoney::dispatch(
                $user,
                $currency,
                $this->createMoneyObject(
                    amount: $amount,
                    moneyCurrency: $currency->iso_code_str
                ),
                $description
            );
            $this->info(__('messages.add_transaction'));
            return self::SUCCESS;
        }
        $this->error(__('messages.transaction_error'));
        return self::FAILURE;
    }
}
