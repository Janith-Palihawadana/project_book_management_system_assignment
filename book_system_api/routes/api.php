<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'auth'
], function (){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class,'register']);
});


Route::group([
    'prefix' => 'books'
], function (){
    Route::post('/get_book_list', [BookController::class, 'getBookList']);
});

Route::group([
    'prefix' => 'books'
], function (){
    Route::post('/get_book_list_by_author', [BookController::class, 'getBooksByAuthor']);
    Route::post('/create_book',[BookController::class , 'createBook']);
    Route::post('/update_book',[BookController::class , 'updateBook']);
    Route::get('/delete-book',[BookController::class , 'deleteBook']);
});


Route::group([
    'prefix' => 'author'
], function (){
    Route::post('/get_all_author_list', [AuthController::class, 'getAllAuthorsList']);
    Route::post('/edit_author', [AuthController::class , 'editAuthor']);
    Route::post('/author_status_change', [AuthController::class , 'authorStatusChange']);
});
