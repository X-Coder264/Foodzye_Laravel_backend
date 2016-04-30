<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;
use Mail;
use Hash;
use DB;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function postResetPassword(Request $request){
        $email = $request->get("email");
		
		
		//random generated 8 chars long password
		$bytes = openssl_random_pseudo_bytes(4);

		$pwd = bin2hex($bytes);
		
        $user = User::where('email', $email)->get();
		//return $pwd;
		
		//shuffle the random generated password 4fun :)
        $shuffled_random_password = str_shuffle($pwd);
		
        $hashed_shuffled_random_password = Hash::make($shuffled_random_password);
		
		//return $hashed_shuffled_random_password;

        DB::table('users')
            ->where('email', $email)
            ->update(['password' => $hashed_shuffled_random_password]);

        Mail::send('auth.emails.password2', ['user' => $user, 'password' => $shuffled_random_password], function ($m) use ($user) {
            $m->from('nino.pauletich@gmail.com', 'Foodzye');

            $m->to($user[0]->email)->subject('Your new password!');
        });

        return "success";
    }

}
