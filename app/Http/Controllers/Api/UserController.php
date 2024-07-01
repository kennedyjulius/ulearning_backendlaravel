<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'avatar' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            $validated = $validateUser->validated();

            $validated = $validateUser ->validated();

            $map=[];
            $map['type'] - $validated['type'];
            $map['open_id'] - $validated['open_id'];

            $user - User::where($map) -> first();

            if (empty($user->id)) {
                $validated['token'] = md5(uniqid().rand(1000, 99999));
                $validated['created_at'] =Carbon::now();
                $userID = User::insertGetId($validated);
                $userInfo = User::where('id', '=', $userID);
                $accessToken = $userInfo->createToken(uniqid())->plainText;

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            }
            $accessToken = $userInfo->createToken(uniqid())->plainTextToken;
            $userInfo->access_token = $accessToken;
    
                return response()->json([
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'token' => $userInfo
                ], 200);
                
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials',
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
