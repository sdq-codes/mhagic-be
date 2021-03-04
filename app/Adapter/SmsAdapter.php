<?php
namespace App\Adapter;

use App\Adapter\Interfaces\SmsAdapterInterface;
use App\Models\User;
use App\Services\Interfaces\SmsServiceInterface;

class SmsAdapter extends BaseFactory implements SmsAdapterInterface
{
    private $smsService;

    private $initiateServices;

    public function __construct(SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    public function plug($message, $telephone)
    {
        $this->smsService->sendSms($message, $telephone);
    }

    public function SendOtp(string $otp, User $user) {
        $message = "Welcome to SWIFT LOGISTICS. Your verification otp is $otp.";
        $this->plug($message, $user->telephone);
    }

    public function sendAdminPassword(string $otp, User $user) {
        $message = "Hello your temporary SwiftLogistics password is $otp. Change it to avoid disconnection.";
        $this->plug($message, $user->telephone);
    }
}
