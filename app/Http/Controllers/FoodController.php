<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


use App\Http\Requests;

class FoodController extends Controller
{
    public function getAllFood(){
        return DB::table('food')->get();
    }


	public function postFood(Request $request){

		$name = $request->get('name');
		
		DB::table('food')->insert([
			"name" => $name
		]);
		
		return "success";
	}
	
	public function postImage(Request $request){
		
        $encoded_string = $request->get('encoded_string');
		//$slug = $request->get('username');
		$slug = "antonio";
		//return $encoded_string;
		$image_name = $request->get('image_name');
		//$image_name = "bla.jpg";
		
		$decoded_string = base64_decode($encoded_string);
		
		$destinationPath = public_path() . '/users/'. $slug.'/food/'.$image_name;
		
		header('Content-Type: bitmap; charset=utf-8');
	
		$file = fopen($destinationPath, 'wb');
	
		$is_written = fwrite($file, $decoded_string);
		
		fclose($file);
		
		if($is_written > 0) {
			return "success";
		}else{
			return "failed";
		}
		
		/*$path = base_path('users/antonio/');
        $base = $image;
        $binary = base64_decode($base);
        header('Content-Type: bitmap; charset=utf-8');

        $f = finfo_open();
        $mime_type = finfo_buffer($f, $binary, FILEINFO_MIME_TYPE);
        $mime_type = str_ireplace('image/', '', $mime_type);

        $filename = md5(\Carbon\Carbon::now()) . '.' . $mime_type;
        $file = fopen($path . $filename, 'wb');
        if (fwrite($file, $binary)) {
            return "success";
        } else {
            return "fail";
        }
        fclose($file);*/
		
	}

}
