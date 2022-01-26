<?php


namespace App\Validations;


use App\Models\Account;
use Illuminate\Http\Request;

class TransactionValidation
{
    public function validateTransaction(Account $account, array $validatedData): bool
    {
        if ($this->validateIban($validatedData['iban'])
            && $this->validateDepositedAmount($account, $validatedData['amount'])
                && $this->validateTransactionToSameIban($account, $validatedData['iban'])
            ) {
            return true;
        }

        return false;
    }

    private function validateIban(string $iban): bool
    {
        $ibanNumber = substr($iban, 8);

        return is_numeric($ibanNumber) && strlen($ibanNumber) === 16 && $this->validateIbanInDatabase($iban);
    }

    private function validateTransactionToSameIban(Account $account, string $iban): bool
    {
        return $account->number !== $iban;
    }

    private function validateIbanInDatabase(string $iban): bool
    {
        return Account::where('number', '=', $iban)->exists();
    }

    private function validateDepositedAmount(Account $account, float $amount): bool
    {
        return $account->balance >= $amount * 100;
    }

    public function validateTransactionInput()
    {
        return request()->validate([
            'iban' => 'required|starts_with:LV420UNI',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|between:1,150'
        ]);
    }
}
