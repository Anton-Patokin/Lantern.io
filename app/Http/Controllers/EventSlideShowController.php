<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\EventNext;
use App\Room;

class EventSlideShowController extends Controller
{
    public function next(Request $request) {
       $roomTitle = $request->json('title');

       $room = Room::where('title', $roomTitle)->get();

       event(new EventNext($room));

       return $room;
   }
}
