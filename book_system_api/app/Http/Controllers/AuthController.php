<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

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

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = ValidationService:: loginValidator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        var_dump("hit me");
        return response()->json("SUCESS", 201);
    }

    public function getAllAuthorsList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = ValidationService::getValidator($request->all());

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

    public function editAuthor(Request $request)
    {
        try {
            $validator = ValidationService::getAuthorValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $get_author = User::where('user_ref',$request['user_ref']);


        } catch (\Exception $e) {

            Log::error($e);
            return response()->json(['error' => 'Failed to fetch authors', 'message' => $e->getMessage(),], 500);
        }

    }
}
