<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use  Illuminate\Support\Facades\Hash;

class AccessController extends Controller
{
    public function index(Request $request, $title)
    {
        $room = Room::where('title', $title)->first();
        if ($room) {

            if (Hash::check($request->cookie('access_key'), $room->password)) {
                return view('room/room_with_password')->with('room', $room)->with('documents', $room->documents()->get());
            } else {
                return view('room/room_with_password')->with('room', $room);
            }
        }
        Session::put('error', 'List not found');
        return redirect('/');
    }
}
