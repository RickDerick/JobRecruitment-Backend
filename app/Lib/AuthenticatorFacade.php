<?php

namespace App\Lib;

use Illuminate\Support\Facades\Facade;

class AuthenticatorFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'authenticator';
    }
}
