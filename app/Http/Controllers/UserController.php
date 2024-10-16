<?php

namespace App\Http\Controllers;

//use App\Traits\GeneralTrait;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
class UserController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {
        try {
            $rules = [
                "email" => "required|exists:users,email",
                "password" => "required"
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            //login
            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('user-api')->attempt($credentials);//make token

            if (!$token) {
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
            }
            $user = Auth::guard('user-api')->user();
            //varible name(api_token) that have token
            $user->api_token = $token;
            //return token
            return $this->returnData('user', $user);//return json response
        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
