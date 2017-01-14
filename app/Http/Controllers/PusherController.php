<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PusherController extends Controller
{
    public function start_slideshow(Request $request){

        $room     = $request->json('roomTitle');
        $isActive = true;

        $pusher = App::make('pusher');

        $pusher->trigger($room,
            'slide-show-active',
            array('slide_show_started' => $isActive));

        return 'Started Slideshow';
    }

    public function stop_slideshow(Request $request) {

        $room     = $request->json('roomTitle');
        $isActive = false;

        $pusher = App::make('pusher');

        $pusher->trigger($room,
            'slide-show-active',
            array('slide_show_started' => $isActive));

        return 'Stopped Slideshow';
    }

    public function move_slide(Request $request) {

        $room = $request->json('roomTitle');
        $url  = $request->json('url');
        $direction = $request->json('direction');

        $pusher = App::make('pusher');

        $pusher->trigger($room,
            'slide-show-move',
            array('url' => $url, 'direction' => $direction));

        return 'move slide ' . $direction;
    }

    public function send_options(Request $request) {

        $room            = $request->json('roomTitle');
        $autoplayEnabled = $request->json('autoplay_enabled');
        $autoplayTimer   = $request->json('autoplay_timer');

        $pusher = App::make('pusher');

        $pusher->trigger($room,
            'slide-show-settings-changed',
            array('autoplay_enabled' => $autoplayEnabled, 'autoplay_timer' => $autoplayTimer));

        return 'settings changed';
    }
}
