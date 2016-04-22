<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ReviewController extends Controller
{
    public function getAllReview()
    {
        return DB::table('review')->get();
    }


    public function postReview(Request $request)
    {

        $menu_id = $request->get('menu_id');
        $user_id = $request->get('user_id');
        $rate = $request->get('rate');
        $comment = $request->get('comment');

        $rating = DB::select('select * from review where user_id = ? and menu_id = ?', array($user_id, $menu_id));


        if ($rating == NULL) {

            DB::table('review')->insert([
                "rate" => $rate,
                "comment" => $comment,
                "menu_id" => $menu_id,
                "user_id" => $user_id
            ]);
            return var_dump($user_id);
            //TODO: this should definetly be done in database
            $menuRating = DB::table('menu')->select('rate_total', 'number_of_votes')->where('id', $menu_id)->get();

            $newRating = ($menuRating[0]->rate_total * $menuRating[0]->number_of_votes + $rate) / ($menuRating[0]->number_of_votes + 1);
            DB::table('menu')->where('id', $menu_id)->increment('number_of_votes');
            DB::table('menu')->where('id', $menu_id)->update(array('rate_total' => $newRating));


        } else {
            DB::table('review')->where('menu_id', $menu_id)->where( 'user_id', $user_id)->update(array('rate' => $rate, 'comment' => $comment ));

                //TODO: this should definetly be done in database
            $menuRating = DB::table('menu')->select('rate_total', 'number_of_votes')->where('id', $menu_id)->get();
            $newRating = ($menuRating[0]->rate_total * $menuRating[0]->number_of_votes + $rate - $rating[0]->rate) / ($menuRating[0]->number_of_votes);


            DB::table('menu')->where('id', $menu_id)->update(array('rate_total' => $newRating));

        }
        return "success";
    }
}
