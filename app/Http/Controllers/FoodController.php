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

}
