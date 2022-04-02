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

Route::get('/', function () {
    return view('index');
})->name("index");
Route::get('/kanban', 'KanbanController@index')->name("kanban");
Route::get('/register', function () {
    return view('auth.register');
})->name("register");

Route::get('/login', function () {
    return view('auth.login');
})->name("login");

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name("forgot-password");

Route::get('/welcome', function () {
    return view('welcome');
})->name("welcome");

Route::get('getboards', 'KanbanController@getBoards')->name("getBoards");

Route::post('verifycardid', 'KanbanController@verifyCardId')->name("verifyCardId");
Route::post('savetodb', 'KanbanController@saveToDB')->name("saveToDB");
Route::get('boardmaxid', 'KanbanController@boardMaxId')->name("boardMaxId");
Route::post('saveboard', 'KanbanController@saveBoard')->name("saveBoard");
Route::get('getcard', 'KanbanController@getCard')->name("getcard");
Route::get('getboard', 'KanbanController@getBoard')->name("getboard");
Route::post('editcard', 'KanbanController@editCard')->name("editCard");
Route::post('editboard', 'KanbanController@editBoard')->name("editBoard");


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
