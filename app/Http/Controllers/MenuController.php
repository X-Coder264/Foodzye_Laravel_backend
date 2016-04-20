<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class MenuController extends Controller
{
    public function getAllMenu(){


        //$menu = DB::table('menu')->get();

        $menu=DB::table('menu')
            ->join('food', 'food.id', '=', 'menu.food_id')
            ->select('menu.*', 'food.name')
            ->get();

        return $menu;

    }


    public function postMenu(Request $request){

        $price = $request->get('price');
        $currency = $request->get('currency');
        $description = $request->get('description');

        DB::table('food')->insert([
            "price" => $price,
            "currency" => $currency,
            "description" => $description
        ]);

        return "success";
    }
}
