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
        $firstImg = $request->json('first_img');
        $isActive = true;

        $roomDB = Room::where('title', $room)->first();

        $roomDB->is_active = $isActive;
        $roomDB->slideshow_owner = $ownerId;
        $roomDB->current_img = $firstImg;

        if( $roomDB->save() ) {
            $pusher = App::make('pusher');

            $pusher->trigger($room,
                'slide-show-active',
                array('slide_show_started' => $isActive, 'first_img' => $firstImg));

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
            $roomDB->current_img = null;

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

        $roomDB->current_img = $url;

        if ( $roomDB->slideshow_owner == $ownerID && $roomDB->save()) {
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

    public function is_active (Request $request) {

        $room = $request->json('roomTitle');

        $roomDB = Room::where('title', $room)->first();

        return Response::json(array('is_active' => $roomDB->is_active, 'current_img' => $roomDB->current_img));
    }
}
