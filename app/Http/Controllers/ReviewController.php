<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReviewController extends Controller
{
    public function getAllReview(){
        return DB::table('review')->get();
    }


    public function postReview(Request $request){

        $rate = $request->get('rate');
        $comment = $request->get('comment');

        DB::table('food')->insert([
            "rate" => $rate,
            "comment" => $comment
        ]);

        return "success";
    }
}
