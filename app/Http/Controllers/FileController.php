<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use Validator;
use Redirect;
use Session;
use App\Document;
use Response;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Image;


class FileController extends Controller
{
    public function file_upload(Request $request)
    {
        //get file from the post request
        $file = array('file' => $request->file('file'));
        // setting up rules
        $rules = array('file' => 'required|mimes:jpeg,gif,bmp,png,jpg|max:8000',); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            //return Redirect::to('test')->withInput()->withErrors($validator);

            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
            //return Response::make($validator->errors()->all(), 400);
        } else {

            // checking file is valid.
            if ($request->file('file')->isValid()) {


                //check of the room ewist
                $room = Room::where('title', $request->title)->first();
                if ($room == null) {
                    return Response::json('error', 400);
                }

                $file = $request->file('file');
                $destinationPath = 'uploads/' . $room->title; // upload path + make folder with unic room
                //set unic name fileName + name + last_name + unic time

                $fileName = $file->getClientOriginalName();

                $extension = $file->getClientOriginalExtension(); // getting image extension


                // uploading file to given path
                if ($file->move($destinationPath, $fileName)) {

                    $dimension = getimagesize($destinationPath . '/' . $fileName);
                    $max_with = "1920";
                    $max_height = "1080";
                    if ($dimension[0] > $max_with) {
                            $save_percent = round(100/$dimension[0]*$max_with)/100;
                            $max_height =round($save_percent*$dimension[1]);
                        Image::make(public_path($destinationPath . '/' . $fileName))
                            ->resize($max_with, $max_height)->save($destinationPath . '/' . $fileName);
                    }
                    if($dimension[1] > $max_height){
                        $save_percent = round(100/$dimension[1]*$max_height)/100;
                        $max_with =round($save_percent*$dimension[0]);
                        Image::make(public_path($destinationPath . '/' . $fileName))
                            ->resize($max_with, $max_height)->save($destinationPath . '/' . $fileName);
                    }


                    //only save document info after upload is done
                    $document = new Document();
                    $document->title = $file->getClientOriginalName();
                    $document->url = $destinationPath . "/" . $fileName;
                    $document->type = $extension;
                    $document->room_id = $room->id;

                    //if document is uoloaded and DB is saved then return success
                    if ($document->save()) {
                        // sending back with message
                        //Session::flash('success', 'Upload successfully');
                        //return Response::json('success', 200);

                        // pusher event for upload
                        $pusher = App::make('pusher');

                        $pusher->trigger($room->title,
                            'upload-file',
                            array('file_updated' => true));

                        return Response::json([
                            'error' => false,
                            'file_id' => $document->id,
                            'file_name' => $fileName,
                            'code' => 200
                        ], 200);
                    }
                } else {
                    return Response::json([
                        'error' => true,
                        'message' => 'Server error while uploading',
                        'code' => 500
                    ], 500);
                };

            }
        }
        return Response::json('error', 400);
    }

    public function file_delete(Request $request)
    {
        $room = Room::where('title', $request->room_title)->first();
        $document = $room->documents()->where('title', $request->title)->get()->first();

        if ($document != null) {
            //return $path = $document->url;
            if ($document->delete()) {
                //ther are two tipes of files fisyc and web if iets fysic delete on server outher way delete from DB only
                if (unlink($document->url)) {

                    $pusher = App::make('pusher');

                    $pusher->trigger($room->title,
                        'delete-file',
                        array('file_deleted' => true));

                    return Response::json([
                        'error' => false,
                        'message' => "Successfully deleted.",
                        'code' => 200
                    ], 200);
                } else {
                    return Response::json([
                        'error' => true,
                        'message' => "Something went wrong.",
                        'code' => 400
                    ], 400);
                };

                // if file is frome web than and iets deleted return succes massage
                return Response::json([
                    'error' => false,
                    'message' => "Successfully deleted.",
                    'code' => 200
                ], 200);

            };

            // id request for delete doesn't work return error massage
            return Response::json([
                'error' => true,
                'message' => "Something went wrong.",
                'code' => 400
            ], 400);
        }

        // if room doesn´t found return error massage -> somebody tray to hack you
        return Response::json([
            'error' => true,
            'message' => "No file with that name in this list",
            'code' => 400
        ], 400);
    }
}
