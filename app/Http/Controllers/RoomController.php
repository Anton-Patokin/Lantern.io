<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Webpatser\Uuid\Uuid;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Room;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Zipper;

class RoomController extends Controller
{
    public function __construct()
    {
//        $this->middleware('accessRoom')->only(['show_room']);
        $this->middleware('accessRoom',['only' => 'show_room']);
    }

    public function access($room){
        return 'okey';
    }

    public function index()
    {
        $uuid = explode('-', Uuid::generate());


         $uuid = $uuid[0] . $uuid[1];

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
        $cookie = Cookie::forever('access_key',$request->password);
        return redirect('/' . $room->title)->withCookie($cookie);
    }

    public function show_room($url)
    {
        $room = Room::where('title', $url)->get()->first();
        if ($room) {
            $files = $room->documents()->get();

            return view('room/room_without_password')->with('documents',$files)->with('room',$room);
        }
        Session::put('error', 'List not found!');
        return redirect('/');
    }

    public function get_documents_room ($title) {
        $url = $title;
        $room = Room::where('title', $url)->get()->first();

        if ($room) {
            $files = $room->documents()->get();

            return response()->json($files);
        }
        else {
            return response()->json([
                'error' => 'No files in this playlist.'
            ], 400);
        }
    }

    public function access_room(Request $request){

        $room = Room::where('title',$request->title)->get()->first();
        if($room){
            if(Hash::check($request->password, $room->password )){
                $cookie = Cookie::forever('access_key',$request->password);
                return redirect('/'.$room->title)->withCookie($cookie);
            }else{
                Session::put('error', 'Wrong password!');
                return redirect('/'.$room->title);
            };
        };
        Session::put('error', 'List not found');
        return redirect('/');
    }

    public function download_room($room)
    {
        $find_room = Room::where('title', $room)->first();
            $files = glob(public_path('uploads\\' . $find_room->title . '\*'));
            $path_name = 'uploads\\' . $find_room->title . '\\' . $find_room->title . '.zip';

            if (file_exists($path_name)) {
                return response()->download(public_path($path_name))->deleteFileAfterSend(true);
            } else {
                if (count($files) == 0) {
                    return redirect('/'.$find_room->title);
                }
                Zipper::make($path_name)->add($files);
                return redirect('/download/list/' . $find_room->title);
            }

        Session::put('error', 'Something went wrong');
        return redirect('/'.$find_room->title);
    }

}
