<?php

namespace App\Observers;

use App\Link;

class LinkObserver
{
    public function saved(Link $link)
    {
        cache()->forget('links');
    }

    public function deleted(Link $link)
    {
        cache()->forget('links');
    }
}
