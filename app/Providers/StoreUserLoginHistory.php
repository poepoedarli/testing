<?php

namespace App\Providers;

use App\Providers\LoginHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Logger;

class StoreUserLoginHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\LoginHistory  $event
     * @return void
     */
    public function handle(LoginHistory $event)
    {
        $user = $event->user;
        $message = $user? '`'.$user->name.'` ['.$user->email.'] logged-in at '.Carbon::now()->toDateTimeString() : '';
        $this->logger->createLog('Login', $message, 'info');
        return true;
    }
}