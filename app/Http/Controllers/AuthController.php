<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $messsages = array(
            'email.required'=>'Enter your email',
            'email.email'=>'Invalid email format',
            'password.required'=>'Password is Required',
        );
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string'
        ], $messsages);

        if ($validator->fails()) {
            return response()->json(['statusCode' => 100 ,'msg' => $validator->messages()]);
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'statusCode' => 400,
                	'msg' => 'Invalid Login Credentials',
                ]);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'statusCode' => 500,
                	'msg' => 'Could not create token',
                ]);
        }
 	
 		//Token created, return with success response and jwt token
        return response()->json([
            'statusCode' => 201,
            'token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['statusCode' => '100' ,'msg' => $validator->messages()]);
        }
    
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'statusCode' => 200,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Sorry, user cannot be logged out'
            ]);
        }
    }
    public function verifyToken()
    {
        return response()->json([ 'status' => auth()->check() ]);
    }
}
