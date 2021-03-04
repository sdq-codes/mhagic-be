<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use App\Models\User;

class PasswordResetNotifications extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var User */
    public $user;


    /** @var string */
    public $respondLink;


    /** @var array */
    public $app;

    /** @var string */
    public $logo;

    /** @var $token */
    public $token;

    /**
     * InviteNotification constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {

        $this->user = $user;
        $token = auth()->login($user);
        $this->token = $token;
        $this->respondLink = site_url('/auth/password/reset') . '?token=' . $this->token;
        $this->logo = env('APP_LOGO');
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @param $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->resetPassword($notifiable);
    }

    /**
     * @param $notifiable
     *
     * @return MailMessage
     */
    protected function resetPassword($notifiable)
    {
        $inviteSubject = ' Reset Password Notification';
        $inviteBody = $this->getBody();
        $inviteFooter = '
        Should you have  any concerns, please send us an email at support@alajehub.com';
        $viewData = array('app'=>$this->app, 'logo' => $this->logo);
        $fullname = $this->user->name;
        return (new MailMessage)->from(config('mail.from.address'), 'AlajeHub Support')
            ->replyTo($this->user->email, $this->user->name)
            ->subject($inviteSubject)
            ->greeting('Hello! ' . $fullname)
            ->line(new HtmlString($inviteBody))
            ->action('Reset Password', $this->respondLink)
            ->line(
                new HtmlString('Click the button above to Reset Your Password!')
            )
            ->line($inviteFooter)
            ->markdown('notifications::email', $viewData);
    }
    /**
     * @return string
     */
    private function  getBody()
    {
        return '<p>You are receiving this email because we received a password reset request for your account. </p>';
    }
}
