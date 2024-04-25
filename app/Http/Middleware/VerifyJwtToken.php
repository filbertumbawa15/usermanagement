<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (null !== $token = $this->getBearerToken($request->header('authorization'))) {
                $payload = JWT::decode($token, new Key(config('jwt.key'), config('jwt.alg')));

                Auth::loginUsingId($payload->sub);
            } else {
                return response([
                    'message' => 'Invalid token',
                ], 401);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return $next($request);
    }

    public function getBearerToken($authorization)
    {
        if (!empty($authorization)) {
            if (preg_match('/Bearer\s(\S+)/', $authorization, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
