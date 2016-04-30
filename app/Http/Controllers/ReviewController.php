<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DB;

class ReviewController extends Controller
{
    public function getAllReview($menu_id)
    {
        $review = DB::table('review')
            ->join('users', 'users.id', '=', 'review.user_id')
            ->select('review.menu_id', 'review.rate', 'review.comment','users.name', 'users.user_picture', 'review.created_at', 'review.updated_at')
            ->where('menu_id',$menu_id)
            ->where('review.comment', '<>', '')
            ->get();

        return $review;
    }
	
	public function getUserReviews($user_id)
	{
		return DB::table('review_user')->join('users', 'review_user.user_id', '=', 'users.id')->select('review_user.*', 'users.name', 'users.user_picture')->where('place_id', $user_id)->get();
	}

    public function getUsersReview ($menu_id, $user_id)
    {
        return DB::table('review')->select('rate', 'comment')->where('user_id', $user_id)->where('menu_id', $menu_id)->get();
    }

    public function getUsersReviewPlace ($place_id, $user_id)
    {
        return DB::table('review_user')->select('rate', 'comment')->where('user_id', $user_id)->where('place_id', $place_id)->get();
    }
	
	public function postFoodServiceReview(Request $request)
	{
		$place_id = $request->get('place_id');
        $user_id = $request->get('user_id');
        $rate = $request->get('rate');
        $comment = $request->get('comment');

        $rating = DB::table('review_user')->select('*')->where('user_id', $user_id)->where('place_id', $place_id)->get();

        if ($rating == NULL) {
            DB::table('review_user')->insert([
                "rate" => $rate,
                "comment" => $comment,
                "place_id" => $place_id,
                "user_id" => $user_id,
                "created_at" => Carbon::now()
            ]);

            $userRating = DB::table('users')->select('rate_total', 'number_of_votes')->where('id', $place_id)->get();

            $newRating = ($userRating[0]->rate_total * $userRating[0]->number_of_votes + $rate) / ($userRating[0]->number_of_votes + 1);
            DB::table('users')->where('id', $place_id)->increment('number_of_votes');
            DB::table('users')->where('id', $place_id)->update(array('rate_total' => $newRating));

        } else{

            DB::table('review_user')->where('place_id', $place_id)->where( 'user_id', $user_id)->update(array('rate' => $rate, 'comment' => $comment,  "updated_at" => Carbon::now()));

            //TODO: this should definetly be done in database
            $userRating = DB::table('users')->select('rate_total', 'number_of_votes')->where('id', $place_id)->get();
            $newRating = ($userRating[0]->rate_total * $userRating[0]->number_of_votes + $rate - $rating[0]->rate) / ($userRating[0]->number_of_votes);


            DB::table('users')->where('id', $place_id)->update(array('rate_total' => $newRating));
        }
			
		return "success";	
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
                "user_id" => $user_id,
                "created_at" => Carbon::now()
            ]);

            //TODO: this should definetly be done in database
            $menuRating = DB::table('menu')->select('rate_total', 'number_of_votes')->where('id', $menu_id)->get();

            $newRating = ($menuRating[0]->rate_total * $menuRating[0]->number_of_votes + $rate) / ($menuRating[0]->number_of_votes + 1);
            DB::table('menu')->where('id', $menu_id)->increment('number_of_votes');
            DB::table('menu')->where('id', $menu_id)->update(array('rate_total' => $newRating));


        } else {
            DB::table('review')->where('menu_id', $menu_id)->where( 'user_id', $user_id)->update(array('rate' => $rate, 'comment' => $comment,  "updated_at" => Carbon::now()));

                //TODO: this should definetly be done in database
            $menuRating = DB::table('menu')->select('rate_total', 'number_of_votes')->where('id', $menu_id)->get();
            $newRating = ($menuRating[0]->rate_total * $menuRating[0]->number_of_votes + $rate - $rating[0]->rate) / ($menuRating[0]->number_of_votes);


            DB::table('menu')->where('id', $menu_id)->update(array('rate_total' => $newRating));

        }
        return "success";
    }

    public function postPlaceReview (Request $request){

    }
}
