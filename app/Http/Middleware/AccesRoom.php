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
                    return redirect('/list/'.$room->title);
            };
            return $next($request);
        }
        Session::put('error', 'Room not found!');
        return redirect('/');
    }
}
