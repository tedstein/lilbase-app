<?php

namespace App\Listeners;

use App\Events\AppCreated;
use App\Models\User;
use App\Notifications\NewApp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAppCreatedNotifications implements ShouldQueue
{
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
     * @param  \App\Events\AppCreated  $event
     * @return void
     */
    public function handle(AppCreated $event)
    {
        foreach (User::where('id', $event->app->user_id)->cursor() as $user)
            $user->notify(new NewApp($event->app));
    }
}
