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

Route::get('getboards', 'KanbanController@getBoards')->name("getBoards");

Route::post('verifycardid', 'KanbanController@verifyCardId')->name("verifyCardId");
Route::post('savetodb', 'KanbanController@saveToDB')->name("saveToDB");
Route::get('tablemaxid', 'KanbanController@tablemaxid')->name("tablemaxid");
Route::post('savetable', 'KanbanController@saveTable')->name("saveTable");
Route::get('getcard', 'KanbanController@getCard')->name("getcard");
Route::post('editcard', 'KanbanController@editCard')->name("editCard");

