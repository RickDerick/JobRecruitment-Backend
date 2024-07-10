<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ApiResponder;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistrationNotice;
use App\Models\User;

class AuthController extends Controller
{
    use ApiResponder;
    public function register(Request $request)
    {
       try {

         $request->validate([
            'email'=>'required|email|string|unique:users',
            'firstName'=>'required|string',
            'middleName'=>'sometimes|string',
            'lastName'=> 'required|string',
            'phone_no'=> 'required|string',
            'password'=>'required|min:8',

        ]);

        $user = User::where('email', $request['email'])->first();

        //check if profile exists
        if($user)
        {
            return $this->error('User Already Exists, Please Login to continue');
        }
        $user = new User();
        $user->name ="";
        $user->email= $request->email;
        $user->phone_no= $request->phone;
        $user->password= Hash::make($request->password);
        $user->otp = generate_user_otp();
        $user->save();
        $user->notify(new UserRegistrationNotice());
        $user->sendOtp($user->otp);


        
       } catch (\Exception $exception) {
        return $this->$exception;
       }
        

        

    }
}
