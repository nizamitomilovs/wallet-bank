<?php


namespace App\Repositories\AccountRepository;


use Illuminate\Support\Facades\DB;

class AccountRepository
{
    public function storeAccount(string $iban, array $validatedRequest): void
    {
        DB::table('accounts')->insert([
            'number' => $iban,
            'user_id' => auth()->user()->id,
            'balance' => $validatedRequest['balance'] * 100,
            'currency' => $validatedRequest['currency']
        ]);
    }
}
