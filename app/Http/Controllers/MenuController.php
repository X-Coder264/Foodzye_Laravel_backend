<?php

namespace App\Http\Controllers;

use App\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class MenuController extends Controller
{
    public function getAllMenu(){

        $menu = DB::table('menu')
            ->join('food', 'food.id', '=', 'menu.food_id')
            ->select('menu.*', 'food.name as foodName')
            ->select('menu.*', 'food.name AS foodName')
            ->get();

        return $menu;

    }

    public function getUserMenu($id){

        $menu = DB::table('menu')
            ->join('users', 'menu.user_id', '=', 'users.id')
            ->join('food', 'food.id', '=', 'menu.food_id')
            ->where('users.id', '=', $id)
            ->select('menu.*', 'food.name AS foodName')
            ->get();

        return $menu;

    }


    public function postMenu(Request $request){
		
		$user_id = $request->get('user_id');
        $slug = $request->get('user_slug');
        $food_id = $request->get('food_id');
        $name = $request->get('name');
        $price = $request->get('price');
        $currency = $request->get('currency');
        $description = $request->get('description');
		$encoded_string = "";
		$image_name = "";
		
		if($request->has('encoded_string')){
			$encoded_string = $request->get('encoded_string');
			$image_name = $request->get('image_name');
			
			
			$decoded_string = base64_decode($encoded_string);

			$destinationPath = public_path() . '/users/'. $slug.'/food/'.$image_name;
			$destinationPath2 = 'users/'. $slug.'/food/'.$image_name;

			header('Content-Type: bitmap; charset=utf-8');

			$file = fopen($destinationPath, 'wb');

			$is_written = fwrite($file, $decoded_string);

			fclose($file);

			if($is_written > 0) {

				DB::table('menu')->insert([
					"user_id" => $user_id,
					"food_id" => $food_id,
					"name" => $name,
					"price" => $price,
					"currency" => $currency,
					"description" => $description,
					"food_image" => $destinationPath2,
					"created_at" => Carbon::now()
				]);

				return "success";
			}else{
				return "failed";
			}
			
		}else{
			DB::table('menu')->insert([
                "user_id" => $user_id,
                "food_id" => $food_id,
                "name" => $name,
                "price" => $price,
                "currency" => $currency,
                "description" => $description,
                "created_at" => Carbon::now()
            ]);

            return "success";
		}

    }
	
	
	public function postEditMenu(Request $request){
        $slug = $request->get('user_slug');
        $menu_id = $request->get('menu_id');
        $name = $request->get('name');
        $price = $request->get('price');
        $currency = $request->get('currency');
        $description = $request->get('description');
		$encoded_string = "";
		$image_name = "";
		
		if($request->has('encoded_string')){
			$encoded_string = $request->get('encoded_string');
			$image_name = $request->get('image_name');
			
			
			$decoded_string = base64_decode($encoded_string);

			$destinationPath = public_path() . '/users/'. $slug.'/food/'.$image_name;
			$destinationPath2 = 'users/'. $slug.'/food/'.$image_name;

			header('Content-Type: bitmap; charset=utf-8');

			$file = fopen($destinationPath, 'wb');

			$is_written = fwrite($file, $decoded_string);

			fclose($file);

			if($is_written > 0) {

				DB::table('menu')->where('id', $menu_id)
					->update([
						"name" => $name,
						"price" => $price,
						"currency" => $currency,
						"description" => $description,
						"food_image" => $destinationPath2,
						"updated_at" => Carbon::now()
					]);

				return "success";
			}else{
				return "failed";
			}
			
		}else{
			DB::table('menu')->where('id', $menu_id)
				->update([
					"name" => $name,
					"price" => $price,
					"currency" => $currency,
					"description" => $description,
					"updated_at" => Carbon::now()
				]);

            return "success";
		}
	}
	
}
