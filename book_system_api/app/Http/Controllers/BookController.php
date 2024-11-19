<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function getBookList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = ValidationService::getValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $getAllBooks = Books::getAllBooks($request->all(),false);
            $getAllBooks_count = Books::getAllBooks($request->all(),true);

            return response()->json([
                'all_books' => $getAllBooks,
                'totalRecords' => $getAllBooks_count,
                ], 200);
        } catch (\Exception $e) {

            Log::error($e);
            return response()->json(['error' => 'Failed to fetch books', 'message' => $e->getMessage(),], 500);
        }
    }

    public function getBooksByAuthor(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = ValidationService::getBooksValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $getAllBooksByAuthor = Books::getAllBooksByAuthor($request->all(),false);
            $getAllBooksByAuthor_count = Books::getAllBooksByAuthor($request->all(),true);

            return response()->json([
                'all_books' => $getAllBooksByAuthor,
                'totalRecords' => $getAllBooksByAuthor_count,
            ], 200);
        } catch (\Exception $e) {

            Log::error($e);
            return response()->json(['error' => 'Failed to fetch books', 'message' => $e->getMessage(),], 500);
        }
    }

    public function updateBooks(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $validator = ValidationService::UpdateBooksValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            return response()->json([
                'message' => 'Book details updated successfully',
            ], 201);
        }
        catch (\Exception $e){
            Log::error($e);
            return response()->json(['error' => 'Update unsuccessful', 'message' => $e->getMessage(),], 500);
        }
    }

    public function deleteBooks(Request $request)
    {

    }
}
