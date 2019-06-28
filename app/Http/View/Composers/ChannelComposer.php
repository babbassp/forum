<?php

namespace App\Http\View\Composers;

use App\Models\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ChannelComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('channels', Cache::rememberForever('channels', function () {
            return Channel::all();
        }));
    }
}