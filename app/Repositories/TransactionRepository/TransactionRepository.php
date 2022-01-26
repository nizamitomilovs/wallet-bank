<?php


namespace App\Repositories\TransactionRepository;


use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function storeTransaction(Account $accountFrom, Account $accountTo ,array $validateRequestData): Transaction
    {


        $this->storeFromAccountAmount($accountFrom, $validateRequestData['amount_from']);

        $this->storeToAccountAmount($accountTo, $validateRequestData['amount_to']);

        return $this->storeTransactionToDatabase($accountFrom, $accountTo, $validateRequestData);
    }

    private function storeFromAccountAmount(Account $accountFrom, float $amount): void
    {
        DB::table('accounts')
            ->where('id', $accountFrom->id)
            ->decrement('balance', $amount * 100);
    }

    private function storeToAccountAmount(Account $accountTo, float $amount): void
    {
        DB::table('accounts')
            ->where('number', $accountTo->number)
            ->increment('balance', $amount * 100);
    }

    private function storeTransactionToDatabase(Account $accountFrom, Account $accountTo, array $request): Transaction
    {


        $transaction = Transaction::create([
            'from_user' => $accountFrom->user_id,
            'to_user' => $accountTo->user_id,
            'from_account' => $accountFrom->number,
            'to_account' => $accountTo->number,
            'description' => $request['description'],
            'amount_from' => $request['amount_from'] * 100,
            'amount_to' => $request['amount_to'] * 100,
        ]);

        $transaction->save();

        return $transaction;
    }
}
