<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class RegisteredSuccess
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $folderName = 'avatars';
        $fileName = time() . '_' . Str::random(5) . '.png';
        $uploadPath = storage_path('app/public/' . $folderName);
        $avatarUrl = \Storage::url("$folderName/$fileName");

        app('auto_avatar')->saveAvatar(Str::random(6), 125, $uploadPath, $fileName);
        \DB::table('users')->where('id', $event->user->id)->update(['avatar' => $avatarUrl]);
    }
}
