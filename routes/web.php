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
use Illuminate\Support\Facades\Session;

/**
 * Index routes
 */
Route::get('/', 'KanbanController@index')->name("index");

/**
 * Protected routes
 */
Route::middleware(['auth','XssSanitizer'])->group(function () {
    Route::get('/search', 'KanbanController@Search')->name("Search");
    Route::post('/searchResult', 'KanbanController@searchResult')->name("SearchResult");
    Route::get('/workgroup/{id}', 'WorkgroupController@index')->name("workgroup")->where('id', '[0-9]+');
    Route::get('/workgroup/users/{id}', 'WorkgroupController@usersManagement')->name("usersManagement")->where('id', '[0-9]+');
    Route::get('/workgroup/users/', 'WorkgroupController@changeRole')->name('changeRole');
    Route::get('/kanban/{id}', 'KanbanController@kanban')->name("kanban")->where('id', '[0-9]+');
    Route::get('/workgroup/', 'WorkgroupController@inviteUser')->name('inviteUser');
    Route::get('/workgroup/delete', 'WorkgroupController@deleteInvitedUser')->name('deleteInvitedUser');
    Route::get('/index/leave', 'WorkgroupController@leaveWorkgroup')->name('leaveWorkgroup');
    Route::get('getboards', 'KanbanController@getBoards')->name("getBoards");
    Route::get('getcard', 'KanbanController@getCard')->name("getcard");
    Route::get('getboard', 'KanbanController@getBoard')->name("getboard");
    Route::get('boardmaxid', 'KanbanController@boardMaxId')->name("boardMaxId");
    Route::get('getkanban', 'WorkgroupController@getKanban')->name("getKanban");
    Route::get('getworkgroup', 'WorkgroupController@getWorkgroup')->name("getWorkgroup");
    Route::get('kanbanInfos', 'KanbanController@kanbanInfos')->name("kanbanInfos");

    Route::post('verifycardid', 'KanbanController@verifyCardId')->name("verifyCardId");
    Route::post('savetodb', 'KanbanController@saveToDB')->name("saveToDB");
    Route::post('saveboard', 'KanbanController@saveBoard')->name("saveBoard");
    Route::post('editcard', 'KanbanController@editCard')->name("editCard");
    Route::post('editboard', 'KanbanController@editBoard')->name("editBoard");
    Route::post('addkanban', 'WorkgroupController@addKanban')->name("addKanban");
    Route::post('addworkgroup', 'WorkgroupController@addWorkgroup')->name("addWorkgroup");

    Route::get('getworkgroup', 'WorkgroupController@getWorkgroup')->name("getWorkgroup");
    Route::get('/workgroup/infos/{id}', 'WorkgroupController@getWorkgroupById')->name("WorkgroupInfosGet")->where('id', '[0-9]+');
    Route::get('/workgroup/infos', function() { return view('workgroup-info');})->name("WorkgroupInfos");
    Route::post('/workgroup/infos/{id}', 'WorkgroupController@UpdateWorkgroupInfos')->name('WorkgroupInfoPost')->where('id', '[0-9]+');

    Route::get('/settings/profile', function() { return view('auth.settings-profile');})->name("settingsProfileGet");
    Route::post('/settings/profile', 'UserSettingController@changePicture')->name("settingsProfilePost");
    Route::get('/settings/email', function() { return view('auth.settings-email');})->name("settingsEmailGet");
    Route::post('/settings/email', 'UserSettingController@changeEmail')->name("settingsEmailPost");
    Route::get('/settings/security', function() { return view('auth.settings-security');})->name("settingsSecurityGet");
    Route::post('/settings/security','UserSettingController@changePassword')->name("settingsSecurityPost");

    Route::post('addChecklist','KanbanController@addChecklist')->name('addChecklist');
    Route::post('addChecklistItem','KanbanController@addChecklistItem')->name('addChecklistItem');
    Route::post('saveChecklist','KanbanController@saveChecklist')->name('saveChecklist');
    Route::post('archiveCard','KanbanController@archiveCard')->name('archiveCard');
    Route::post('archiveBoard','KanbanController@archiveBoard')->name('archiveBoard');
    Route::post('joinCard','KanbanController@joinCard')->name('joinCard');

    Route::post('editKanban','KanbanController@editKanban')->name('editKanban');
    Route::post('joinKanban','KanbanController@joinKanban')->name('joinKanban');
    Route::post('uploadFile','KanbanController@uploadFile')->name('uploadFile');

    Route::post('deleteFile','KanbanController@deleteFile')->name('deleteFile');
    Route::post('deleteItem','KanbanController@deleteItem')->name('deleteItem');

    Route::post('readAlert','KanbanController@readAlert')->name('readAlert');
    Route::get('getAlert','KanbanController@getAlert')->name('getAlert');

    Route::get('showFile/{id}','KanbanController@showFile')->name('showFile')->where('id', '[0-9]+');

    Route::get('archived/{id}','KanbanController@archived')->name('archived');
    Route::get('getArchived','KanbanController@getArchived')->name('getArchived');

    Route::post('addComment','KanbanController@addComment')->name('addComment');
    Route::post('deleteComment','KanbanController@deleteComment')->name('deleteComment');

    Route::post('unarchiveBoard','KanbanController@unarchiveBoard')->name('unarchiveBoard');
    Route::post('unarchiveCard','KanbanController@unarchiveCard')->name('unarchiveCard');

    Route::post('useLabel','KanbanController@useLabel')->name('useLabel');
    Route::post('addLabel','KanbanController@addLabel')->name('addLabel');
    Route::post('deleteLabel','KanbanController@deleteLabel')->name('deleteLabel');

});
Route::get('debug', 'KanbanController@debug')->name("debug");

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
Route::post('forgot-password', 'UserSettingController@submitForgetPasswordForm')->middleware('XssSanitizer')->name('forget.password.post');
Route::get('reset-password/{token}', 'UserSettingController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'UserSettingController@submitResetPasswordForm')->middleware('XssSanitizer')->name('reset.password.post');

Auth::routes();

/**
 * Error routes
 */
Route::get('404', function(){
    return view('error.404');
})->name('notfound');
