<?php

namespace App\Http\Controllers\Auth;

use App\Classes\AuthClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    /**
     * @var AuthClass
     */
    private $authClass;

    public function __construct() {
        $this->authClass = new AuthClass;
    }

    public function login(Request $request){
        $this->validate($request,[
            'username' => 'required|string|min:6',
            'password' => 'required|string|min:6|regex:/^.*(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d).{10,}.*$/'
        ]);
        return $this->authClass->loginUser($request->only(['username','password']));
    }


    public function register(Request $request){
        $this->validate($request,[
            'country' => 'required|string',
            'password' => 'required|string|min:6|regex:/^.*(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d).{10,}.*$/',
            'username' => 'required|string|unique:users|min:6',
            'phone' => 'required|numeric|unique:users'
        ]);

        return $this->authClass->registerUser($request->all());
    }

    public function userVerification(Request $request){
        $this->validate($request,[
            'otp' => 'required'
        ]);
        $user =  $request->user();
        return $this->authClass->verifyUserEmail($user,$request->otp);
    }

    public function resendVerification(Request $request){
        $user = $request->user();
        return $this->authClass->resendVerificationEmail($user);
    }

    public function resetPasswordMail(Request $request){
        $this->validate($request,[
            'phone' => 'required|numeric'
        ]);

        return $this->authClass->sendResetPasswordMail($request->phone);
    }

    public function passwordReset(Request $request){
        $this->validate($request,[
            'token' => 'required',
            'password'=> 'required|confirmed'
        ]);
        $user =  $request->user();
        return $this->authClass->resetPassword($user,$request->only(['password', 'token']));
    }
}
