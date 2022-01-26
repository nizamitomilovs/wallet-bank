<?php

namespace App\Providers;

use App\Events\AccountWasCreated;
use App\Events\TransactionWasMade;
use App\Listeners\AccountWasCreated\SendEmailListener;
use App\Listeners\TransactionWasMade\AlertUserListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TransactionWasMade::class => [
            AlertUserListener::class
        ],
        AccountWasCreated::class => [
            SendEmailListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
