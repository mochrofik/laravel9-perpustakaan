<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\AuthController::class, 'index']  )->middleware('guest')->name('login');
Route::get('/register', function () {
    return view('register.register');
})->middleware('guest');

Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']  )->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']  );

Route::post('/logout',  [App\Http\Controllers\AuthController::class, 'logout'] );

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::group(['middleware' => ['role:member','auth']], function () {
    
    Route::get('/loans', [App\Http\Controllers\LoanController::class, 'index'] );
    Route::post('/loans', [App\Http\Controllers\LoanController::class, 'loanBook'] );
    Route::get('/my-loans', [App\Http\Controllers\LoanController::class, 'myLoans'] );
    Route::get('/return-loans/{id}', [App\Http\Controllers\LoanController::class, 'loanReturn'] );

});
Route::group(['middleware' => ['role:admin', 'auth']], function () {
    Route::get('/master', function(){
        return view('master_data.index');
    });

    //Book Categories
    Route::get('/book-categories', [App\Http\Controllers\BookCategoryController::class, 'index'] )->name('book-categories');
    Route::get('/detail/{id}', [App\Http\Controllers\BookCategoryController::class, 'show'] );
    Route::get('/get-detail/{id}', [App\Http\Controllers\BookCategoryController::class, 'getShow'] );
    Route::get('/get-book-categories', [App\Http\Controllers\BookCategoryController::class, 'getCategories'])->name('get-book-categories');
    Route::post('/add-book-category', [App\Http\Controllers\BookCategoryController::class, 'addBookCategories'])->name('add-book-category');
    Route::put('/update-book-category/{id}', [App\Http\Controllers\BookCategoryController::class, 'updateBookCategories']);
    Route::delete('/delete-book-category/{id}', [App\Http\Controllers\BookCategoryController::class, 'destroy']);
    
    
    //Books
    Route::get('/books', [App\Http\Controllers\BookController::class, 'index'] )->name('books');
    Route::post('/books', [App\Http\Controllers\BookController::class, 'store'] );
    Route::post('/update-book', [App\Http\Controllers\BookController::class, 'update'] );
    Route::get('/books/{id}', [App\Http\Controllers\BookController::class, 'destroy'] );

    Route::get('/get-template-excel', [App\Http\Controllers\BookController::class, 'templateExcel'] );
    Route::post('/import-excel', [App\Http\Controllers\BookController::class, 'importBook'] );
    Route::get('/export-pdf', [App\Http\Controllers\BookController::class, 'exportPDF'] );
    Route::get('/export-excel', [App\Http\Controllers\BookController::class, 'exportExcel'] );


    //Member

    Route::get('/member', [App\Http\Controllers\MemberController::class, 'index']);
    
    
    //Loans
    Route::get('/member-loans', [App\Http\Controllers\LoanController::class, 'memberLoans']);

    

    
});

Route::get('/show/{id}', [App\Http\Controllers\BookController::class, 'show'] )->middleware('auth');