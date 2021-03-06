<?php

namespace Baas\LaravelVisitorLogger\App\Listeners;

use Illuminate\Auth\Events\Logout;
use Baas\LaravelVisitorLogger\App\Http\Traits\VisitorActivityLogger;

class LogSuccessfulLogout
{
    use VisitorActivityLogger;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Logout $event
     *
     * @return void
     */
    public function handle(Logout $event)
    {
        if (config('LaravelVisitorLogger.logSuccessfulLogout')) {
            VisitorActivityLogger::activity('Logged Out');
        }
    }
}
