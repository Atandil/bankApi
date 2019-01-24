<?php
/**
 * Created by PhpStorm.
 * Author: Damian Barczyk
 * Date: 24/01/2019
 * Time: 03:18
 */

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(!$request->hasHeader('Authorization')) {
            return response()->json('Authorization Header not found', 401);
        }

        $token = $request->bearerToken();

        if($request->header('Authorization') == null || $token == null) {
            return response()->json('No token provided', 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json(
                [
                    'error' => 'Provided token is expired.',
                ],
                400
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'msg'   => $e->getMessage(),
                    'error' => 'An error while decoding token.',
                ],
                400
            );
        }
        $user = User::find($credentials->sub);
        //Huray :) we are auth
        $request->auth = $user;
        return $next($request);
    }




}