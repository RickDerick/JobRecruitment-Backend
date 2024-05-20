<?php

namespace App\Lib;

use App\Models\UserOneTimePassword;
use App\Notifications\OneTimePasswordMailNotice;
use App\Notifications\OneTimePasswordSmsNotice;
use Carbon\Carbon;

trait HasOtp
{
    public function sendOtp(): void
    {
        $otp = UserOneTimePassword::where([
            'user_id' => $this->user->id
        ])->get();

        foreach ($otp as $item) {
            $item->expires_at = Carbon::now();
            $item->save();
        }

        $userOtp = new UserOneTimePassword();
        $userOtp->otp = uniqueCode(
            $userOtp,
            "otp",
            env('OTP_LENGTH') ?: 4,
            '',
            false
        );

        $userOtp->user_id = $this->user->id;
        $userOtp->expires_at = Carbon::now()->addMinutes(60);
        $userOtp->save();

        switch ($this->username) {
            case "email":
                $this->user->notify(new OneTimePasswordMailNotice($userOtp));
                break;
            case "phone":
                $this->user->notify(new OneTimePasswordSmsNotice($userOtp));
                break;
        }
    }

    public function verifyOtp(string $otp): bool
    {

        $userOtp = UserOneTimePassword::where([
            'otp' => $otp,
            'user_id' => $this->user->id,
        ])->whereNull('verified_at')->first();


        if (!$userOtp) {
            return false;
        }


        if (Carbon::now()->diffInMinutes(Carbon::parse($userOtp->expires_at)) <= 0) {

            return false;
        }


        $userOtp->verified_at = Carbon::now();
        $userOtp->save();

        return true;
    }

    public function otpResponse(): array
    {
        return [
            "message" => "OTP has been sent to your " . $this->username,
            "expires_at" => Carbon::now()->addMinutes(60)
        ];
    }
}