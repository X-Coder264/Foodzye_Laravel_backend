<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => ['api']], function () {
    Route::post('register', 'Auth\AuthController@postRegisterUser');
    Route::post('login', 'Auth\AuthController@login');
    Route::post('postResetPassword', 'Auth\PasswordController@postResetPassword');

    Route::get('getFood', 'FoodController@getAllFood');
    Route::post('postFood', 'FoodController@postFood');

    Route::post('food_image', 'FoodController@postImage');

    Route::get('getMenu', 'MenuController@getAllMenu');
    Route::get('getMenu/{id}', 'MenuController@getUserMenu');
    Route::post('postMenu', 'MenuController@postMenu');
	Route::post('postEditMenu', 'MenuController@postEditMenu');


    Route::get('getReview/{id1}', 'ReviewController@getAllReview');
	Route::post('postFoodServiceReview', 'ReviewController@postFoodServiceReview');
    Route::post('postReview', 'ReviewController@postReview');
	Route::get('getUserReviews/{id}', 'ReviewController@getUserReviews');
    Route::get('getUsersReview/{id1}/{id2}', 'ReviewController@getUsersReview');
    Route::get('getUsersReviewPlace/{id1}/{id2}', 'ReviewController@getUsersReviewPlace');

    Route::post('postPlaceReview', 'ReviewController@postPlaceReview');
    Route::get('getPlaceReview/{id1}/{id2}', 'ReviewController@getPlaceReview');

    Route::get('getUser/{id}', 'PlaceController@getUser');
    Route::post('postUserUpdate', 'PlaceController@postUserUpdate');
    Route::get('getPlace', 'PlaceController@getAllPlace');

    Route::get('getPremiumTypes', 'PayPalController@getPremiumTypes');
    Route::post('postPayment', 'PayPalController@postPayment');
	
});
