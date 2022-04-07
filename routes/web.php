<?php

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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/**
 * Index routes
 */
Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::get('/', 'KanbanController@index')->name("index");

/**
 * Protected routes
 */
Route::middleware('auth')->group(function () {
    Route::get('/kanban', 'KanbanController@kanban')->name("kanban");
    Route::get('getboards', 'KanbanController@getBoards')->name("getBoards");
    Route::get('getcard', 'KanbanController@getCard')->name("getcard");
    Route::get('getboard', 'KanbanController@getBoard')->name("getboard");
    Route::get('boardmaxid', 'KanbanController@boardMaxId')->name("boardMaxId");

    Route::post('verifycardid', 'KanbanController@verifyCardId')->name("verifyCardId");
    Route::post('savetodb', 'KanbanController@saveToDB')->name("saveToDB");
    Route::post('saveboard', 'KanbanController@saveBoard')->name("saveBoard");
    Route::post('editcard', 'KanbanController@editCard')->name("editCard");
    Route::post('editboard', 'KanbanController@editBoard')->name("editBoard");
});

/**
 * Auth routes
 */
Route::get('/register', function () {
    return view('auth.register');
})->name("register");

Route::get('/login', function () {
    return view('auth.login');
})->name("login");

Route::get('forgot-password', 'UserSettingController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forgot-password', 'UserSettingController@submitForgetPasswordForm')->name('forget.password.post'); 
Route::get('reset-password/{token}', 'UserSettingController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'UserSettingController@submitResetPasswordForm')->name('reset.password.post');


Auth::routes();

/**
 * Error routes
 */
Route::get('404', function(){
    return view('error.404');
})->name('notfound');
