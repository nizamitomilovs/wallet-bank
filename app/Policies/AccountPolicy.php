<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    public function update(User $user, Account $account): bool
    {
        return $user->id == $account->user_id;
    }


    public function delete(User $user, Account $account): bool
    {
        return $user->id == $account->user_id;
    }
}
