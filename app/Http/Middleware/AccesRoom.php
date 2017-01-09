<?php

namespace App\Http\Middleware;

use Closure;
use App\Room;

class AccesRoom
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $room = Room::where('title', $request->route('title'))->first();
//        return $next($request);
        if ($room) {
            if (isset($room->password)&&$room->password != "") {
//                if cookie set retrif check password and redirect to view
                return 'view whit password';
//                return view('room/room')->with('access','denied')->with('room',$room);
            };
            return view('room/room_without_password')->witch('files','');
        }
        Session::put('error', 'Room not found!');
        return redirect('/');
        return $next($request);
//        if ($room != null) {
//            foreach ($room->users as $user) {
//
//                if ($user->pivot->user_id === Auth::id()) {
//
//                    if($user->pivot->access != true){
//
//                        Session::put('error', 'You don\'t have permission to access this room');
//                        return redirect('/dashboard');
//                    }
//
//                    return $next($request);
//                }
//            }
//            return redirect('/key/' . $room->title);
//        } else {
//            Session::put('error', 'Room not found!');
//            return redirect('/dashboard');
//        }
//
//        return $next($request);
    }
}
