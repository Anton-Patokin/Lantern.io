<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PusherController extends Controller
{
    public function start_slideshow(Request $request){

        $room     = $request->json('roomTitle');
        $url      = $request->json('url');
        $isActive = true;

        $pusher = App::make('pusher');

        $pusher->trigger($room,
            'slide-show-start',
            array('url' => '/' . $url, 'slide_show_started' => $isActive));

        return 'Started Slideshow';
    }

    public function stop_slideshow(Request $request) {

        $room     = $request->json('roomTitle');
        $isActive = false;

        $pusher = App::make('pusher');

        $pusher->trigger($room,
            'slide-show-start',
            array('slide_show_started' => $isActive));

        return 'Stopped Slideshow';
    }
}
