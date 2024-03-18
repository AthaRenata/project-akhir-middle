<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JwtToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends ApiController
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        $secretApiKey = $request->header('authorization');

        if($validator->fails()){
            return $this->sendBadRequest($validator->messages());
        }

        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {
            if ($secretApiKey==config('services.api_secret_key')) {
                $token = JwtToken::setData([
                    'id' => Auth::user()->id,
                    'role' => Auth::user()->role
                ])
                ->build();
                return $this->sendSuccess($token);
            }else{
                return $this->sendBadRequest("API key tidak valid");
            }
        }else{
            return $this->sendBadRequest("Login gagal");
        }

    }

    public function logout(Request $request){
        JwtToken::blacklist();
        return $this->sendSuccess("Berhasil logout");
    }
}
