<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {

        $validator = ValidationService:: registrationValidator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }
    public function loginUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = ValidationService::loginValidator($request->all());
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json("User does not exist", 422);
            }

            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user = Auth::user();

            $token = $user->createToken('example')->accessToken;

            $roleKey = Roles::where('id', $user['role_id'])->first();

            $user->api_token =  $token;
            $user->save();

            return response()->json([
                'token' => $token,
                'name' => $user->name,
                'key' => $roleKey->key,
            ], 200);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'error' => 'Failed to log in',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAllAuthorsList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = ValidationService::getValidatorAuthors($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $getAllAuthor = User::getAuthors($request->all(), false);
            $getAllAuthorCount = User::getAuthors($request->all(), true);


            return response()->json([
                'all_author' => $getAllAuthor,
                'totalRecords' => $getAllAuthorCount,
            ], 200);
        } catch (\Exception $e) {

            Log::error($e);
            return response()->json(['error' => 'Failed to fetch authors', 'message' => $e->getMessage(),], 500);
        }
    }

    public function authorStatusChange(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = ValidationService::getAuthorDetailValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $get_author = User::where('user_ref',$request['author_ref'])->first();
            $get_author->is_active = $request['is_active'];
            $get_author->save();
            return response()->json("Author status change Successful", 201);

        } catch (\Exception $e) {

            Log::error($e);
            return response()->json(['error' => 'Author status change unsuccessful', 'message' => $e->getMessage(),], 500);
        }
    }
}
