<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\OneTimePasswordMailNotice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'firstName',
        'lastName',
        'secondName',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = ['profile','profile_photo_url'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function routeNotificationForSms ($notifiable): string
    {
        return format_phone_no($this->phone);
    }
    
    public function oneTimePasswords()
    {
        return $this->hasMany(UserOneTimePassword::class);
    }

    public function sendOtp($code = null)
    {
        $this->otp = $code ? : generate_user_otp();
        $this->save();
        try {
            $this->notify(new OneTimePasswordMailNotice());
        } catch (\Exception $exception) {
            Log::error('Error sending OTP code mail notification', ['error' => $exception->getMessage()]);
        }
    }
}
