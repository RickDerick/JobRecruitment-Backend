<?php

namespace App\Concerns;

use App\Models\UserOneTimePassword;
use App\Notifications\OneTimePasswordMailNotice;
use App\Notifications\OneTimePasswordSmsNotice;
use Carbon\Carbon;
use Exception;

trait HasOtp
{

    public function sendOtp(string $channel = 'email', string $type = 'LOGIN'): void
    {
        UserOneTimePassword::where([
            'type' => $type,
            'user_id' => $this->id
        ])->delete();

        $userOtp = new UserOneTimePassword();
        $userOtp->otp = uniqueCode(
            $userOtp,
            "otp",
            env('OTP_LENGTH') ?: 4,
            '',
            false
        );

        $userOtp->user_id = $this->id;
        $userOtp->expires_at = Carbon::now()->addHours(24);
        $userOtp->type = $type;
        $userOtp->save();

        if ($channel === 'email')
            $this->notify(new OneTimePasswordMailNotice($userOtp));

        if ($channel === 'phone')
            $this->notify(new OneTimePasswordSmsNotice($userOtp));
    }

    /**
     * @throws Exception
     */
    public function verifyOtp(string $otp, string $type = 'LOGIN'): UserOneTimePassword
    {
        $userOtp = UserOneTimePassword::where([
            'otp' => $otp,
            'user_id' => $this->id,
            'type' => $type,
        ])->whereNull('verified_at')->first();

        if (!$userOtp)
            throw new Exception('Invalid User oTP');

        if (Carbon::now()->diffInHours(Carbon::parse($userOtp->expires_at)) <= 0)
            throw new Exception("OTP code Expired");

        $userOtp->verified_at = Carbon::now();
        $userOtp->save();

        return $userOtp;
    }

    public static function getUser(string $otp)
    {
        return UserOneTimePassword::whereOtp($otp)->first();
    }

    public function hasUnverifiedOtp(string $type = null): bool
    {
        return $this->oneTimePasswords()
                ->where('user_id', $this->id)
                ->whereNull('verified_at')
                ->when($type, function ($q) use ($type) {
                    return $q->whereType($type);
                })->count() > 0;
    }

}
