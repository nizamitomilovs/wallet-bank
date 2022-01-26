<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('accounts', 'AccountsController')->middleware(['auth']);

Route::get('/transactions/transfer/{account}', 'TransactionController@transferTable')
    ->middleware(['auth', 'password.confirm'])->name('transactions.transferTable');

Route::post('/transactions/transfer/{account}', 'TransactionController@transfer')
    ->middleware(['auth'])->name('transactions.transfer');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
