<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'getFood',
        'postFood',

        'food_image',

        'getReview',
        'postReview',
        'getUsersReview',
        'getUsersReviewPlace',
        'postFoodServiceReview',

        'postPlaceReview',
        'getPlaceReview',

        'getMenu',
        'postMenu',
        'getUserMenu',

        'register',
        'login',
        'postResetPassword',
        'getLogin',

        'getUser',
        'postUserUpdate',
        'getPlace',


    ];
}
