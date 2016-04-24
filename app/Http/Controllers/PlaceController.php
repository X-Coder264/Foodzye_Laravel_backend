<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class PlaceController extends Controller
{
    public function getAllPlace()
    {
        return DB::table('users')->where('role',2)->get();

    }


}
