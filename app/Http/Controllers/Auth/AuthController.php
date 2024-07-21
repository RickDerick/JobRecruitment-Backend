<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\ApiResponder;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistrationNotice;
use Laravel\Sanctum\PersonalAccessToken;


use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ApiResponder;
    public function register(Request $request)
    {
       try {

         $request->validate([
            'email'=>'required|email|string|unique:users',
            'firstName'=>'required|string',
            'secondName'=>'sometimes',
            'lastName'=> 'required|string',
            'phone_no'=> 'required',
            'password'=>'required|min:8',

        ]);

        $user = User::where('email', $request['email'])->first();

        //check if profile exists
        if($user) return $this->error('User Already Exists, Please Login to continue');

        $user = new User();
        $user->name ="";
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->secondName = $request->secondName;
        $user->email= $request->email;
        $user->phone_no= $request->phone_no;
        $user->password= Hash::make($request->password);
        $user->otp = generate_user_otp();
        $user->save();
        $user->notify(new UserRegistrationNotice());
        $user->sendOtp($user->otp);
       return $this->success($user->refresh());
        
       } catch (\Exception $exception) {
        Log::error('Error on Registration', ['error'=>$exception->getMessage()]);
        return $this->error('Registration failed', 500);
       }

    }

    public function verifyOtp(Request $request)
    {
        try {

            $request->validate([
                "email" => 'required|email',
                "otp" => "required",
            ]);
            
            $user = User::where('otp', $request->otp)->first();

            if(!$user) return $this->error('Invalid Otp code', 404);
            $user->otp = null;
            $user->save();

            return $this->success([
                'message' => 'Verification Successful',
                'user' => $user->refresh(),
                'token' => $user->createToken("Recruitment")->plainTextToken
            ]);

    
        } catch (\Exception $exception) {
            Log::error('Error while verifying otp', ['error'=>$exception->getMessage()]);
            return $this->error('verificaton failed', 500);
    }
}

    public function login(Request $request)
       {
        try {
            $request->validate([
                'email'=>'required|email',
                'password'=>'required',
            ]);
            $user = User::where('email', $request['email'])->first();
            if($user===null) return $this->error('The email provided does not exist');
        
            if (! $user || ! Hash::check($request->password, $user->password)){
                return $this->error('The provided credentials are not correct');
           }
           $token= $user->createToken("Recruitment")->plainTextToken;
           return $this->success([
            'user' => $user->refresh(),
           'token' =>$token
        ]);
        } catch (\Exception $exception) {
            Log::error('Error ocurred while trying to login', ['error'=>$exception->getMessage()]);
        }
        
}

public function logout(Request $request)
{
    try {
        if(!empty($request->all())){
            $token = PersonalAccessToken::where('tokenable_id', $request->id)->first();
        }else {
            $token = $request->user()->currentAccessToken();
        }
        $token->delete();

        /* clear application cache */
        return response()->json([
            'message' => 'logout success',
        ], 200);
    }catch (\Exception $exception){
        return $this->exception($exception);
    }
}

}
