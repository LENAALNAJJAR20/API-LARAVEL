<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
//use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
    {
        try {
            $rules = [
                "email" => "required|exists:admins,email",
                "password" => "required"
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('admin-api')->attempt($credentials);//make token
            if (!$token) {
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
            }
            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;
//            //return token
            return $this->returnData('admin', $admin);
        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('auth-token');
        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate(); //logout
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->returnError('', 'some thing went wrongs');
            }
            return $this->returnSuccessMessage('Logged out successfully');
        } else {
            $this->returnError('', 'some thing went wrongs');
        }
    }
}
