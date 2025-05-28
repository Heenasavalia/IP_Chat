<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('user/login');
})->name('user_login');


Route::group(['prefix'=>'user'],function(){
    Route::post('/check_login',[UserController::class,'check_login']);
    
    Route::group(['middleware'=>'auth'],function(){
        
        Route::get('/logout', function () {
            auth()->logout();
            return redirect()->route('user_login');
        })->name('user_logout');

        Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard');
        Route::post('/search_user',[UserController::class,'search_user'])->name('search_user');

        Route::post('/userwise_group_list',[GroupController::class,'userwise_group_list'])->name('userwise_group_list');
        Route::post('/create_group',[GroupController::class,'create_group'])->name('create_group');
        Route::get('/chat/{id}',[GroupController::class,'group_chat'])->name('group_chat');
        Route::post('/send_group_message',[GroupController::class,'send_group_message'])->name('send_group_message');
        Route::post('/get_group_messages',[GroupController::class,'get_group_messages'])->name('get_group_messages');
    });

});
