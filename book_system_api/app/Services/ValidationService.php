<?php

namespace App\Services;

use App\Models\Books;
use Illuminate\Support\Facades\Validator;

class ValidationService
{
    public static function registrationValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|min:6|string|same:password',
        ]);
    }

    public static function getValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'page_no' => 'required|numeric',
            'page_size' => 'required|numeric',
            'keyword' => 'nullable|string|max:255',
        ]);
    }

    public static function loginValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    }

    public static function getBooksValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'page_no' => 'required|numeric',
            'page_size' => 'required|numeric',
            'keyword' => 'nullable|string|max:255',
        ]);
    }

    public static function UpdateBooksValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'book_ref'=> 'required|string|exists:books,book_ref',
            'title'=>'required|string|max:255',
            'cover_image'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
        ]);
    }
    public static function createBookValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description'=>'nullable|string|max:255',
        ]);
    }

    public static function getAuthorValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'author_ref' => 'required|string|exists:users,user_ref',
        ]);
    }

    public static function getValidatorAuthors($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'page_no' => 'required|numeric',
            'page_size' => 'required|numeric',
            'keyword' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);
    }

    public static function getAuthorDetailValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'author_ref' => 'required|string|exists:users,user_ref',
            'is_active' => 'required|boolean',
        ]);
    }

    public static function bookValidator($request): \Illuminate\Validation\Validator
    {
        return Validator::make($request,[
            'book_ref' => 'required|string|exists:books,book_ref',
        ]);
    }

}
