<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\User;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

            //TO DO not work this one
            $author_id = 3;

            $getAllBooksByAuthor = Books::getAllBooksByAuthor($author_id,$request->all(),false);
            $getAllBooksByAuthor_count = Books::getAllBooksByAuthor($author_id,$request->all(),true);

            foreach ($getAllBooksByAuthor as $book) {
                $book->cover_image_url = url(Storage::url($book->cover_image));
            }

            return response()->json([
                'all_books' => $getAllBooksByAuthor,
                'totalRecords' => $getAllBooksByAuthor_count,
            ], 200);
        } catch (\Exception $e) {

            Log::error($e);
            return response()->json(['error' => 'Failed to fetch books', 'message' => $e->getMessage(),], 500);
        }
    }

    public function updateBook(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $validator = ValidationService::UpdateBooksValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            Books::updateBook($request->all());

            return response()->json([
                'message' => 'Book details updated successfully',
            ], 201);
        }
        catch (\Exception $e){
            Log::error($e);
            return response()->json(['error' => 'Update unsuccessful', 'message' => $e->getMessage(),], 500);
        }
    }

    public function deleteBook(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = ValidationService::bookValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $book = Books::where('book_ref',$request['book_ref'])->first();

            $book->is_active = 0;
            $book->save();

            return response()->json([
                'message' => 'Book deleted successfully',
            ], 201);
        }
        catch (\Exception $e){
                Log::error($e);
                return response()->json(['error' => 'Book add unsuccessful', 'message' => $e->getMessage(),], 500);
            }
    }


    public function createBook(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $validator = ValidationService::createBookValidator($request->all());

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            if ($request->hasFile('cover_image')) {
                $coverImagePath = $request->file('cover_image')->store('public/book_images'); // Store in public folder
            } else {
                $coverImagePath = null;
            }

            //TODO Auth::id
//            $author_id = Auth::id();


            $book = Books::create([
                'title' => $request['title'],
//                'author_name' => $author_id,
                'cover_image' => $coverImagePath,
//                'created_user_id' => $author_id,
                'description'=>$request['description'],
            ]);

            return response()->json([
                'message' => 'Book add successfully',
            ], 201);
        }
        catch (\Exception $e){
            Log::error($e);
            return response()->json(['error' => 'Book add unsuccessful', 'message' => $e->getMessage(),], 500);
        }

    }
}
