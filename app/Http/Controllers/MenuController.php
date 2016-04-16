<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MenuController extends Controller
{
    public function getAllMenu(){
        return DB::table('menu')->get();
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
