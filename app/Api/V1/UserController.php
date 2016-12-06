<?php
namespace App\Api\V1;

use App\User;
use Dingo\Api\Http\Request;
use JWTAuth;

class UserController extends ApiController
{
    public function index()
    {
        return \App\User::all();
    }

    public function create(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $validator = \Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $data['password'] = app('hash')->make($data['password']);
        $user = User::create($data);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('token'));
    }
}
