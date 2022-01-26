<?php


namespace App\Validations;


use App\Models\Account;

class AccountValidation
{
    public function checkAccountBalance(Account $account): bool
    {
        return $account->balance > 0;
    }

}
