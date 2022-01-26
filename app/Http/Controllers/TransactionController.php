<?php

namespace App\Http\Controllers;

use App\Events\TransactionWasMade;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\CurrenciesRepositories\CurrenciesRepositoryInterface;
use App\Repositories\CurrenciesRepositories\LatvijasBankRepository;
use App\Repositories\TransactionRepository\TransactionRepository;
use App\Validations\RateValidation;
use App\Validations\TransactionValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;


class TransactionController extends Controller
{
    use TwoFactorAuthenticatable;

    private CurrenciesRepositoryInterface $currenciesRepository;

    public function __construct(CurrenciesRepositoryInterface $currenciesRepository)
    {
        $this->currenciesRepository = $currenciesRepository;
    }

    public function transferTable(Account $account)
    {
        return view('accounts.transfer', [
            'account' => $account,
        ]);
    }

    public function transfer(Account $account, Request $request)
    {
        $validatedData = (new TransactionValidation)->validateTransactionInput();

        if (!(new TransactionValidation)->validateTransaction($account, $validatedData)) {
            return back()->withError('Please check your input!');
        }

        //find user where goes transaction
        $accountTo = Account::where('number', $request->iban)->first();

        if ($this->checkCurrency($account, $accountTo)) {
            $validatedData['amount_to'] =
                $this->convertCurrency($validatedData['amount'], $account->currency, $accountTo->currency);
        } else {
            $validatedData['amount_to'] = $validatedData['amount'];
        }

        $validatedData['amount_from'] = $validatedData['amount'];

        $transaction = (new TransactionRepository())->storeTransaction($account, $accountTo, $validatedData);

        event(new TransactionWasMade($transaction));

        return redirect()->route('accounts.index');
    }

    private function checkCurrency(Account $fromAccount, Account $toAccount): bool
    {
        return $fromAccount->currency !== $toAccount->currency;
    }

    private function convertCurrency($amount, $from, $to): float
    {
        if ((new RateValidation())->compareTime()) {
            $this->currenciesRepository->getRates();
        }

        $from = $this->getRateFromDatabase(strtoupper($from));

        $to = $this->getRateFromDatabase(strtoupper($to));

        $rate = $to / $from;

        return round($amount * $rate, 6);
    }

    private function getRateFromDatabase(string $currency): float
    {
        return DB::table('rates')->where('name', $currency)->value('rate');
    }

}
