<?php

namespace App\Listeners\TransactionWasMade;

use App\Events\TransactionWasMade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class AlertUserListener
{
    public function handle(TransactionWasMade $event)
    {
        $transaction = $event->transaction;

        $basic  = new \Nexmo\Client\Credentials\Basic(
            config('services.nexmo.nexmo_key'),
            config('services.nexmo.nexmo_password'));
        $client = new \Nexmo\Client($basic);

        $userName = DB::table('users')->where('id', $transaction->from_user)->value('name');
        $text = 'Transaction from ' . $userName . PHP_EOL .' account ' . $transaction->from_account . PHP_EOL;

        $client->message()->send([
            'to' => config('services.nexmo.phone_number'),
            'from' => 'UniCorn',
            'text' => $text
        ]);
    }
}
