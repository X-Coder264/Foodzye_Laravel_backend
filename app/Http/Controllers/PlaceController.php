<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class PlaceController extends Controller
{

    public function getUser($id)
    {
        return DB::table('users')->where('id', $id)->get();

    }

    public function postUserUpdate(Request $request){
        $data = $request->all();

        if($request->has("encoded_string")){
            $decoded_string = base64_decode($data['encoded_string']);

            $path = '/users/'. $data['slug'].'/food/'.$data['image_name'];
            $destinationPath = public_path() . $path;

            header('Content-Type: bitmap; charset=utf-8');

            $file = fopen($destinationPath, 'wb');

            $is_written = fwrite($file, $decoded_string);

            fclose($file);

            if($is_written > 0) {
                DB::table('users')
                    ->where('id', $data['user_id'])
                    ->update([
                        "email" => $data['email'],
                        "location" => $data['location'],
                        "phone" => $data['phone'],
                        "work_time" => $data['work_time'],
                        "user_picture" => $path
                    ]);
                return "success";
            }else{
                return "failed";
            }
        }else{
            DB::table('users')
                ->where('id', $data['user_id'])
                ->update([
                    "email" => $data['email'],
                    "location" => $data['location'],
                    "phone" => $data['phone'],
                    "work_time" => $data['work_time']
                ]);
        }

        return "success";
    }

    public function getAllPlace()
    {
        return DB::table('users')->where('role', 2)->get();

    }
}
