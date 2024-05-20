<?php

namespace App\Lib;

use App\Concerns\HasJsonResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Authenticator
{
    use HasOtp, HasJsonResponse;

    const EMAIL_FIELD = 'email';

    const PHONE_FIELD = 'phone';

    public null|User $user;

    public string $username;

    public Request $request;

    public string $authenticatable;

    public function __construct()
    {
        $this->authenticatable = User::class;
        $this->setUsername(env('AUTH_USERNAME') ?: 'email');
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Authenticator
    {
        $this->user = $user;
        return $this;
    }

    public function setUsername(string $username): Authenticator
    {
        $this->username = $username;
        return $this;
    }

    public function validate(array $fields): void
    {
        $validationFields = [];

        foreach ($fields as $field => $rule) {
            $validationFields[$field] = $rule ?: 'required';
        }

        $this->request->validate($validationFields);
    }

    public function init(Request $request): static
    {
        $this->request = $request;
        $user = $this->authenticatable::where($this->username, $request->get($this->username))->first();

        if ($user)
            $this->setUser($user);

        return $this;
    }

    public function loginResponse(): array
    {
        return [
            "authStatus" => 'success',
            "user" => $this->user,
            "token" => $this->user->createToken('QuireX')->plainTextToken,
            'token_type' => 'bearer',
            'expires_at' => Carbon::now()->addMinutes(config('sanctum.expiration'))->toDateTimeString(),
        ];
    }

    public function failedLoginResponse(): array
    {
        return [
            "authStatus" => 'error',
            $this->username => [trans('auth.failed')],
        ];
    }

    public function attemptLogin(): bool
    {
        return auth()->attempt($this->request->only($this->username, 'password'));
    }
}