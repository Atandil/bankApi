<?php
/**
 * Created by PhpStorm.
 * Author: Damian Barczyk
 * Date: 24/01/2019
 * Time: 02:52
 */
namespace App\Http\Controllers;
use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Create a new token.
     *
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(Request $request) {

        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
        // Find the user by email
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {

            return response()->json([
                'error' => 'User does not exist.'
            ], 400);
        }
        // Verify the password and generate the token
        if (Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }
}
