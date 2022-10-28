<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'country_code' => ['required','string','max:5'],
                'phone_no' => ['required','string','min:6','max:20',]
            ]
            );
        if($validator->fails()){
            return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
        }

        // Check if user exists
        $userExists = User::where('country_code', $request->country_code)
            ->where('phone_no', $request->phone_no)->first();
        if(!empty($userExists)){
            // Create access token
            $token = $userExists->createToken('Access Token');
            return $this->appResponse(true,'success','Access token',['user_id'=>$userExists->id,'access_token'=>$token->accessToken],200);
        }

        $user = new User();
        $user->country_code = $request->country_code;
        $user->phone_no = $request->phone_no;
        $user->otp = null;
        $user->otp_expires =  null;
        $user->save();

        // Create access token
        $token = $user->createToken('Access Token');
        return $this->appResponse(true,'success','Access token',['user_id'=>$user->id,'access_token'=>$token->accessToken],200);
    }

    // public function confirmPhone(Request $request)
    // {
    //     $validator = Validator::make($request->all(),
    //         ['otp'=>['required','numeric']]
    //     );
    //     if($validator->fails()){
    //         return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
    //     }
    //     $user = User::where('phone_no', $request->phone_no)->where('otp', $request->otp)->first();
    //     if(empty($user)){
    //         return $this->appResponse(false,'error','Invalid User',[],404);
    //     }

    //     // clear otp
    //     $user->otp = null;
    //     $user->otp_expires = null;
    //     $user->save();

    //     // Create access token
    //     $token = $user->createToken('Access Token');
    //     return $this->appResponse(true,'success','Phone Confirmed',['access_token'=>$token->accessToken],200);
    // }

    // public function resendConfirmPhone(Request $request)
    // {
    //     $user = User::where('phone_no', $request->phone_no)
    //         ->where('country_code',$request->country_code)->first();
    //     $user->otp = mt_rand(1111,9999);
    //     $user->otp_expires =  Carbon::now()->addHours(2);
    //     $user->save();
    //     $data = ['OTP'=>$user->otp,'phone_no'=>$user->phone_no];
    //     return $this->appResponse(true,'success','OTP expires in 2 hours',$data,200);
    // }
}
