<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'avatar' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'type' => 'required', // Assuming 'type' is a required field
                'open_id' => 'required' // Assuming 'open_id' is a required field
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            $validated = $validateUser->validated();

            $map = [];
            $map['type'] = $validated['type'];
            $map['open_id'] = $validated['open_id'];

            $user = User::where($map)->first();

            if (empty($user)) {
                $validated['token'] = md5(uniqid() . rand(1000, 99999));
                $validated['created_at'] = Carbon::now();
                $validated['password'] = Hash::make($validated['password']);
                $validated['password'],
                $userId = User::inserGetId($validated);
                $userInfo = User::where('id', '=', $userID)->first();
                $user = User::create($validated);
            }

            $accessToken = $user->createToken(uniqid())->plainTextToken;
            $user->access_token = $accessToken;
            User::where('id', '=', $userID)->update(['access_token'=>$accessToken]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $accessToken,
                'user' => $user
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
