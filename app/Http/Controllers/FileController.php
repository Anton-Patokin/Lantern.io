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


class FileController extends Controller
{
    public function file_upload(Request $request)
    {
//      get file from the post request
        $file = array('file' => $request->file('file'));
        // setting up rules
        $rules = array('file' => 'required|mimes:jpeg,gif,bmp,png,jpg|max:8000',); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        
        if ($validator->fails()) {
            // send back to the page with the input data and errors
//            return Redirect::to('test')->withInput()->withErrors($validator);

            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
//            return Response::make($validator->errors()->all(), 400);
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

                $fileName = time() . "-" . $file->getClientOriginalName();

                $extension = $file->getClientOriginalExtension(); // getting image extension


                // uploading file to given path
                if ($file->move($destinationPath, $fileName)) {
//                    only save document info after upload is done
                    $document = new Document();
                    $document->title = $file->getClientOriginalName();
                    $document->url =  $destinationPath . "/" . $fileName;
                    $document->type = $extension;
                    $document->room_id = $room->id;

                    //if document is uoloaded and DB is saved then return success
                    if ($document->save()) {
                        // sending back with message
//                        Session::flash('success', 'Upload successfully');
//                        return Response::json('success', 200);
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
        $document = $room->documents()->where('title', $request->document_title)->get()->first();

        if ($document != null) {


//    return $path = $document->url;


            if ($document->delete()) {
                //ther are two tipes of files fisyc and web if iets fysic delete on server outher way delete from DB only
                if (unlink($document->url)) {
                    return Response::json([
                        'error' => false,
                        'message' => "delete successful",
                        'code' => 200
                    ], 200);
                } else {
                    return Response::json([
                        'error' => true,
                        'message' => "Something went wrong tray later one more time",
                        'code' => 400
                    ], 400);
                };

                // if file is frome web than and iets deleted return succes massage
                return Response::json([
                    'error' => false,
                    'message' => "delete successful",
                    'code' => 200
                ], 200);

            };

            // id request for delete doesn't work return error massage
            return Response::json([
                'error' => true,
                'message' => "Something went wrong tray later one more time",
                'code' => 400
            ], 400);
        }

        // if room doesn´t found return error massage -> somebody tray to hack you 
        return Response::json([
            'error' => true,
            'message' => "This file has not been added to aur system",
            'code' => 400
        ], 400);
    }


}
