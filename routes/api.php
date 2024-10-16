<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['api', 'checkPassword']], function () {
    Route::get('get-main-categories', [CategoriesController::class, 'index']);
    Route::get('get-category-byId', [CategoriesController::class, 'getCategoryById']);
    Route::get('change-category-status', [CategoriesController::class, 'changeStatus']);
    Route::group(['prefix' => 'admin'], function () {
        Route::get('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout'])->middleware('auth.guard:admin-api');
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::get('login', [UserController::class, 'login']);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth.guard:user-api'], function() {
    Route::get('profile', function() {
        return \Auth::user(); //return authenticated user data
    });
});

Route::group(['middleware' => ['api', 'checkPassword', 'checkAdminToken:admin-api']], function () {
    Route::get('offers', [CategoriesController::class, 'index']);
});
