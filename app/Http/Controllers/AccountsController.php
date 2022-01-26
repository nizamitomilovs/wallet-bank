<?php

namespace App\Http\Controllers;

use App\Events\AccountWasCreated;
use App\Models\Account;
use App\Models\User;
use App\Repositories\AccountRepository\AccountRepository;
use App\Validations\AccountValidation;
use App\Validations\RateValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountsController extends Controller
{
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();

        $transactions = DB::table('transactions')
            ->where('to_user', Auth::id())
            ->orWhere('from_user', Auth::id())
            ->latest()
            ->take(10)
            ->get();


        return view('accounts.index', [
            'accounts' => $accounts,
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store()
    {
        $iban = $this->generateUniqueCode();

        $validatedRequest = $this->validateAccount();

        (new AccountRepository())->storeAccount($iban, $validatedRequest);

        $user = auth()->user();

        event(new AccountWasCreated($user));

        return redirect()->route('accounts.index');
    }


    public function show(Account $account)
    {
        $transactions = DB::table('transactions')
            ->where('to_account', $account->number)
            ->orWhere('from_account', $account->number)
            ->latest()
            ->get();


        return view('accounts.show', [
            'account' => $account,
            'transactions' => $transactions
        ]);
    }

    public function update(Account $account)
    {
        $this->authorize('update', $account);

        $validatedData = request()->validate([
            'deposit' => 'required|numeric|min:0.01',
        ]);

        DB::table('accounts')
            ->where('id', $account->id)
            ->increment('balance', $validatedData['deposit'] * 100);

        return redirect()->route('accounts.index');
    }

    public function edit(Account $account)
    {
        return view('accounts.edit', [
            'account' => $account
        ]);
    }


    public function destroy(Account $account)
    {
        if ((new AccountValidation())->checkAccountBalance($account))
        {
            return redirect()->route('accounts.index')
                ->with('message', 'Please Transfer Money To Another Account Before Deleting!');
        }

        $account->delete();

        return redirect()->route('accounts.index');
    }

    private function generateUniqueCode(): string
    {
        $bankCode = 420;

        $bankAccount = 'UNI';

        $bankCountry = 'LV';

        do {
            $number = str_pad(mt_rand(1, 9999999999999999), 16, '0', STR_PAD_LEFT);

            $unique_code = $bankCountry . $bankCode . $bankAccount . $number;
        } while (Account::where('number', $unique_code)->count() > 0);

        return $unique_code;
    }

    private function validateAccount()
    {
        return request()->validate([
            'balance' => 'required|numeric|min:0.01',
            'currency' => 'required|in:eur,usd,gbp',
        ]);
    }
}
