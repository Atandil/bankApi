<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use App\User;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {

        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

        $auth_sucess=false;

        if($has_supplied_credentials) {

            $user=User::where('email',$_SERVER['PHP_AUTH_USER'])->first();

            if($user) {
                if (Hash::check($_SERVER['PHP_AUTH_PW'], $user->password)) {
                    $auth_sucess=true;
                    return $next($request);
                }
            }

        }

        $is_not_authenticated = (
            !$has_supplied_credentials || !$auth_sucess
        );
        if ($is_not_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }
        return $next($request);
    }

}