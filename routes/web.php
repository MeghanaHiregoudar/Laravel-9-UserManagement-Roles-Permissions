<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/**FRONTSITE ROUTES */
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;



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

// To clear application cache
Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return 'Application optimized';
});

Auth::routes();

/******************************* LANDING PAGE CONTROLLERS*****************************************************************/

    /*****************Home page routes*******************************/
    Route::controller(AuthenticationController::class)->group(function() {                       
        Route::get('/','index')->name('login');
        Route::post('/login','authenticated')->name('login.post');
        Route::get('/reload-captcha','reloadCaptcha');
        Route::get('/logout','logout')->name('logout');
    });  

    Route::middleware(['auth','isAdmin','PreventBackHistory'])->group(function(){
        Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');       


        /*****************User Routes (using group routes)**********************************************/
        Route::controller(UserController::class)->group(function() {
            Route::get('/users','index')->name('user');
            Route::get('/users/list','getUserData')->name('user_list');
            Route::get('/user/create','create')->name('user_create');
            Route::post('/user/store','store')->name('user_store');
            Route::get('/user/{id}/edit','edit')->name('user_edit');
            Route::post('/user/update','update')->name('user_update');            
            Route::post('/user/delete','destroy')->name('user_delete');
            Route::post('/user/status','changeStatus')->name('user_status');
        }); 
        
        
    });

   


