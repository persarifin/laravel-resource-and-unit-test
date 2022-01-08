<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Criterias\SearchCriteria;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function __construct() 
    {
        parent::__construct(User::class);
    }

    public function login($request)
    {
        try {
            $user = $this->getModel()->where('email', $request['email'])->first();

            if ($user && \Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'email' => $user->email,
                        'token' => $user->createToken($user->id . '-'. $user->name)->accessToken,
                        'username' => $user->username
                    ]
                ], 200);
            }else {
                throw new \Exception("Invalid email or password", 406);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function register($request) 
    {
        try {
            $payload = $request->all();
            $payload['email'] = strtolower($payload['email']);
            $payload['password'] = Hash::make($payload['password']);

            $user = User::create($payload);
            $user->dana()->create([
                'amount' => 100000
            ]);
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'token' => $user->createToken($user->id . '-'. $user->name)->accessToken,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
