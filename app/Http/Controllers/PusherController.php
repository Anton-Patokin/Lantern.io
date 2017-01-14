<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PusherController extends Controller
{
    public function redirect_img(Request $request){

        $room = $request->roomTitle;
        $url =  $request->url;
        $pusher = App::make('pusher');

        $pusher->trigger( 'test-channel',
            'test-event',
            array('text' => 'Preparing the Pusher Laracon.eu workshop!'));

        return 'done and done';
    }
}
