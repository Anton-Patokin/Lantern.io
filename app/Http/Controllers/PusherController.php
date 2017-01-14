<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PusherController extends Controller
{
    public function redirect_img(Request $request){

        $room = $request->json('roomTitle');
        $url =  $request->json('url');

        $pusher = App::make('pusher');

        $pusher->trigger($room,
            'slide-show-start',
            array('url' => '/' . $url, 'slide-show-started' => true));

        return 'done and done';
    }
}
