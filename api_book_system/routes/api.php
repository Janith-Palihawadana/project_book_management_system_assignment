<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'auth'
], function (){
    Route::post('/login', [UserController::class, 'loginUser']);
    Route::post('/register', [UserController::class,'register']);
});


Route::group([
    'prefix' => 'books'
], function (){
    Route::post('/get_book_list', [BookController::class, 'getBookList']);
});

Route::group([
    'prefix' => 'books',
      'middleware' => 'auth:api',
], function (){
    Route::post('/get_book_list_by_author', [BookController::class, 'getBooksByAuthor']);
    Route::post('/create_book',[BookController::class , 'createBook']);
    Route::post('/update_book',[BookController::class , 'updateBook']);
    Route::get('/delete-book',[BookController::class , 'deleteBook']);
});


Route::group([
    'prefix' => 'author',
    'middleware' => 'auth:api',
], function (){
    Route::post('/get_all_author_list', [UserController::class, 'getAllAuthorsList']);
    Route::post('/author_status_change', [UserController::class , 'authorStatusChange']);
});
