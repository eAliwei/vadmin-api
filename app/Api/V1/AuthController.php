<?php
namespace App\Api\V1;

use Dingo\Api\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = \Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            // 验证失败返回401
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function refreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();
        return response()->json(compact('token'));
    }
}
