<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
			"name" => $name,
			"created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
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
		
	}

}
