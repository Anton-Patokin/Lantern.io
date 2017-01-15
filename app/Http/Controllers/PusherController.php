<?php

namespace App\Http\Controllers;

use Response;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PusherController extends Controller
{
    public function start_slideshow(Request $request){

        $room     = $request->json('roomTitle');
        $ownerId  = $request->json('owner_id');
        $isActive = true;

        $roomDB = Room::where('title', $room)->first();

        $roomDB->is_active = $isActive;
        $roomDB->slideshow_owner = $ownerId;

        if( $roomDB->save() ) {
            $pusher = App::make('pusher');

            $pusher->trigger($room,
                'slide-show-active',
                array('slide_show_started' => $isActive));

            return Response::json(array('error' => false, 'slideshow_active' => true), 200);
        }
        else {
            return Response::json(array('error' => true, 'slideshow_active' => false), 400);
        }
    }

    public function stop_slideshow(Request $request) {

        $room     = $request->json('roomTitle');
        $ownerID  = $request->json('owner_id');
        $isActive = false;

        $roomDB = Room::where('title', $room)->first();

        if ( $roomDB->slideshow_owner == $ownerID ) {
            $roomDB->is_active = $isActive;
            $roomDB->slideshow_owner = null;

            if ( $roomDB->save() ) {
                $pusher = App::make('pusher');

                $pusher->trigger($room,
                    'slide-show-active',
                    array('slide_show_started' => $isActive));

                return Response::json(array('error' => false, 'slideshow_active' => false), 200);
            }
            else {
                return Response::json(array('error' => true, 'slideshow_active' => true), 400);
            }
        }
    }

    public function move_slide(Request $request) {

        $room      = $request->json('roomTitle');
        $ownerID   = $request->json('owner_id');
        $url       = $request->json('url');
        $direction = $request->json('direction');

        $roomDB = Room::where('title', $room)->first();

        if ( $roomDB->owner_id == $ownerID ) {
            $pusher = App::make('pusher');

            $pusher->trigger($room,
                'slide-show-move',
                array('url' => $url, 'direction' => $direction));

            return Response::json(array('error' => false, 'direction' => $direction), 200);
        }
        else {
            return Response::json(array('error' => true, 'direction' => 'error'), 400);
        }
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
