<?php

namespace App\Listeners\AccountWasCreated;

use App\Events\AccountWasCreated;
use App\Mail\AccountCreationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(AccountWasCreated $event)
    {
        \Mail::to($event->user->email)->send(
            new AccountCreationEmail($event->user)
        );
    }
}
