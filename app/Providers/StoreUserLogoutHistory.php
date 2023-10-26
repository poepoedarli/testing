<?php

namespace App\Providers;

use App\Providers\LogoutHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Logger;

class StoreUserLogoutHistory
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
     * @param  \App\Providers\LogoutHistory  $event
     * @return void
     */
    public function handle(LogoutHistory $event)
    {
        $user = $event->user;
        $message = $user? '`'.$user->name.'` ['.$user->email.'] logged-out at '.Carbon::now()->toDateTimeString().'.' : '';
        $this->logger->createLog('Logout', $message, 'info');
        return true;
    }
}
