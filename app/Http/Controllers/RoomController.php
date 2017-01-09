<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Webpatser\Uuid\Uuid;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Room;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('accessRoom');
    }

    public function index()
    {
        return Room::find(1)->files()->get();
        $uuid = explode('-', Uuid::generate());

        $uuid = $uuid[2] . $uuid[1] . $uuid[4] . $uuid[0];

        return view('welcome')->with('url', $uuid);
    }

    public function create_room(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:100|unique:rooms',
            'password' => 'max:255|min:6',
        ]);

        $room = new Room;
        $room->title = $request->title;
        $room->password = $request->password ==""?null:Hash::make($request->password);
        $room->save();
        return redirect('/' . $room->title);
    }

    public function show_room($url)
    {
        $room = Room::where('title', $url)->get()->first();
        if ($room) {
            if (isset($room->password)&&$room->password != "") {
                return view('room/room')->with('access','denied')->with('room',$room);
            };
            return view('room/room');
        }
        Session::put('error', 'Room not found!');
        return redirect('/');

    }
    public function access_room(Request $request){


        $room = Room::where('title',$request->title)->get()->first();
        if(Hash::check($request->password, $room->password )){

            $cookie = Cookie::forever('acceptCookie','okey');


            return view('room/room')->with('access','denied')->with('room',$room)->withCookie($cookie);
        }else{
            Session::put('error', 'Wrong password!');
        };

        return '';
    }
}
