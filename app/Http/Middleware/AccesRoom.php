<?php

namespace App\Http\Middleware;

use Closure;
use App\Room;
Use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Cookie;

class AccesRoom
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        echo 'okey';
        $room = Room::where('title', $request->route('title'))->first();
        if ($room) {
            if (isset($room->password) && $room->password != "") {

                if (Hash::check($request->cookie('access_key'), $room->password)) {
                    $cookie = Cookie::forever('access',1);
                    return redirect('/list/'.$room->title)->withCookie($cookie);
                } else {
                    
                    $cookie = Cookie::forever('access',0);
                    return redirect('/list/'.$room->title)->withCookie($cookie);
                }
            };
            return $next($request);
        }
        Session::put('error', 'Room not found!');
        return redirect('/');
    }
}
