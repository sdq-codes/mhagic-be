<?php


namespace App\Classes;


use App\Adapter\Interfaces\SmsAdapterInterface;
use App\Events\AccountRegistered;
use App\Events\PasswordReset;
use App\Exceptions\CustomValidationFailed;
use App\Exceptions\RecordNotFoundException;
use App\Http\Resources\UserResource;
use App\Models\PasswordResetDb;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\Wallet;
use App\Traits\ActivityManager;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\JWT;

class AuthClass
{
    use ActivityManager;
    /**
     * @var User
     */
    private $user;

    private  $auth;

    private $activityLog;

    private $smsAdapter;

    public function __construct(
    ) {
        $this->user = new User();
        $this->auth = Auth::guard('api');
        $this->activityLog = new UserActivity;
//        $this->smsAdapter = $smsAdapter;
    }

    public function loginUser($data){
        $user = null;
        DB::transaction(function () use (&$user,$data){
            $token = $this->auth->attempt(['username' => $data['username'],'password' => $data['password']]);
            if (!$token){
                throw new AuthenticationException('invalid email or password');
            }
            $user = $this->user->find($this->auth->user()->id);
            $user->access_token = $token;
        });
        return response()->fetch('Login Successful',$user,'user');
    }

    public function registerUser($data){
        $user = null;
        DB::transaction(function () use (&$user,$data){
            $password = Hash::make($data['password']);
             $user = $this->user->create([
                 'password' => $password,
                 'country' => $data['country'],
                 'username' => $data['username'],
                 'phone' => $data['phone']
             ]);
             $token = auth()->login($user);
             $user->access_token = $token;
             Wallet::create([
                 'userId' => $user->id,
                 'oldBalance' => 0,
                 'newBalance' => 0,
                 'amount' => 0
             ]);
        });
        $message = "Registration  Successful.. Please Kindly Check Your Email For aVerification OTP to continue your registration";
        return response()->fetch($message,
            $user,'user');

    }

    protected function sendVerificationEmail(object $user):void {
        $length = 5;
        $otp =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil
        ($length/strlen($x)) )),1,$length);
        DB::table('email_otp')->updateOrInsert(['user_id' => $user->id],[
            'user_id' => $user->id,
            'otp' => $otp
        ]);
        event(new AccountRegistered($user));
        return;

    }

    protected function loginChecks($user): void
    {
        if (!$user->email_verified) {
            throw new AuthorizationException('kindly  verify your email before login');
        }
        if ($user->user_type === 'sub_admin' &&  !$this->activityLog->where('user_id',$user->id)->exists()) {
            throw new AuthorizationException('kindly reset your password before login');
        }
    }

    public function verifyUserEmail($user,$otp){
        $user_otp = DB::table('email_otp')->where('user_id',$user->id)->first()->otp;
        if($user_otp === $otp){
            $user->email_verified = 1;
            $user->save();
            $token = auth()->login($user);
            $user->access_token = $token;
            $resource = new UserResource($user);
            $this->activityLog($user->id,"$user->name Account Verified",'verification');
            return response()->updated('user verified successfully',$resource,'user');
        }
        throw new CustomValidationFailed('the otp is invalid');

    }

    public function resendVerificationEmail($user){
        $this->sendVerificationEmail($user);
        $resource = new UserResource($user);
        $this->activityLog($user->id,"$user->name Password  Verification Email Resend",'verification');
        return \response()->fetch('verification mail resent successfully',$user,'user');
    }

    public function sendResetPasswordMail($telephone){
        $otp =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil
        (8/strlen($x)) )),1,8);
        $user = User::where('phone', $telephone)->first();
        if ($user) {
            DB::transaction(function () use ($user, $otp) {
                PasswordResetDb::create([
                    "token" => $otp,
                    "userId" => $user->id
                ]);
            });
        }
        return \response()->created('password reset sent successfully', true,'reset');
    }

    public function resetPassword($user,$data){
        $password = Hash::make($data['password']);
        $user->password = $password;
        $user->save();
        $token = auth()->login($user);
        $user->access_token = $token;
        $resource = new UserResource($user);
        $this->activityLog($user->id,"$user->name Password Reset",'reset');
        return response()->updated('Password Reset successfully',$resource,'user');
    }



}
