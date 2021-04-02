<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use JWTAuth;
use Validator;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;


class JWTAuthController extends Controller
{
    public function register(Request $request) {
        

        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function login(Request $request) {
    
        $credentials = $request->only('email', 'password');
        if (! $token = auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $this->respondWithToken($token);
    }

    public function user() {
        return response()->json(Auth::guard('api')->user());
    }

    public function refresh() {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
