<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\JwtToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = JwtToken::getToken();
        
        $isBlacklistToken = JwtToken::isBlacklist();
        if($isBlacklistToken || !$token){
            return $this->sendUnauthorized('Your token was not found !');
        }

        try{
            $decodedToken = JwtToken::decode($token);
            $user = $decodedToken->data;
            if($user->role!==1){
                return $this->sendForbidden("You don't have access to this endpoint");
            }

            $request->merge([
                'userCredential' => [
                    'id' => $user->id
                ]
            ]);

            return $next($request);
        }catch(\Exception $e){
            if($e instanceof ExpiredException){
               return $this->sendUnauthorized('Your token was expired');
            }
            return $this->sendUnauthorized('Your token was invalid');
        }
        return $next($request);
    }

    private function sendUnauthorized($message = "Unauthorized")
    {
        return response()->json([
            'code' => 401,
            'message' => $message,
        ], 401);
    }

    private function sendForbidden($message = "Forbidden")
    {
        return response()->json([
            'code' => 403,
            'message' => $message,
        ], 403);
    }

    
}
