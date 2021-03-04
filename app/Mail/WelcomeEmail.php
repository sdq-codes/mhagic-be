<?php


namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class WelcomeEmail extends  Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var User  */
    public $user;

    /** @var string  */
    public $loginLink;

    /** @var string  */
    public $baseUrl;

    /* @var $token **/
    public $token;

    /* @var $logo **/
    public $logo;

    /* @var $otp **/

    public $otp;
    /**
     * WelcomeEmail constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->otp = DB::table('email_otp')->where('user_id',$user->id)->first()->otp;
        $this->baseUrl = site_url('/');
        $this->loginLink = site_url('/login');
        $this->logo = env('APP_LOGO');

    }


    public function build()
    {
        $subject = $this->user->firstname . 'Welcome to '.env('APP_NAME');
        $supportEmail = config('mail.from.address');
        $supportName = config('mail.from.name');
        return $this->from(config('mail.from.address'), $supportName)
            ->replyTo($supportEmail, $supportName)
            ->subject($subject)
            ->view('emails.welcome');
    }
}
