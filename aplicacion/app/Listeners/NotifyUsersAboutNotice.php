<?php

namespace App\Listeners;

use App\Events\NoticeCreated;
use App\Notifications\NoticePublish;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyUsersAboutNotice
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
     * @param  NoticeCreated  $event
     * @return void
     */
    public function handle(NoticeCreated $event)
    {
        $users = User::all();
        Notification::send($users, new NoticePublish($event->notice));
    }
}
