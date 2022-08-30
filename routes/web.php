<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WorkSpaceManagementController;
use App\Http\Controllers\NewArrivalManagementController;

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

Route::get('/', [LoginController::class, 'login'])->name('home');

// Route::get('/login', [LoginController::class, 'login']) -> name('login');

Route::post('/', [LoginController::class, 'checkLogin'])->name('auth.login');

Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');

Route::get('/change_pw', [UsersManagementController::class, 'changePassword'])->name('account.changepw');

Route::prefix('user')->middleware('check.admin')->group(function ()

{
    Route::get('/', [UsersManagementController::class, 'index'])->name('homepage');

    Route::get('/search', [UsersManagementController::class, 'search'])->name('user.search');

    Route::get('/add', [UsersManagementController::class, 'add'])->name('user.add');

    Route::post('/add', [UsersManagementController::class, 'store'])->name('user.store');

    Route::get('/modify/{id}', [UsersManagementController::class, 'modify'])->name('user.modify');

    Route::get('/detail/{id}', [UsersManagementController::class, 'detail'])->name('user.detail');

    Route::post('/modify/{id}', [UsersManagementController::class, 'update'])->name('user.update');

    Route::post('/active/{id}', [UsersManagementController::class, 'active'])->name('user.active');

    Route::post('/reset_pw/{id}', [UsersManagementController::class, 'resetpw'])->name('user.resetpw');

});


Route::prefix('work-space-management')->middleware('check.admin')->group( function()
{

    Route::get('/', [WorkSpaceManagementController::class,'index']) -> name('worksm.homepage');

    Route::get('/search', [WorkSpaceManagementController::class, 'search'])->name('worksm.search');

    Route::get('/add', [WorkSpaceManagementController::class,'add']) -> name('worksm.add');

    Route::post('/add', [WorkSpaceManagementController::class, 'store'])->name('worksm.store');

    Route::delete('/delete/{id}', [WorkSpaceManagementController::class,'delete']) -> name('worksm.delete');

    Route::get('/modify/{id}', [WorkSpaceManagementController::class,'modify']) -> name('worksm.modify');

    Route::post('/modify/{id}', [WorkSpaceManagementController::class, 'update']) -> name('worksm.update');

    Route::get('/detail/{id}', [WorkSpaceManagementController::class,'detail']) -> name('worksm.detail');

});


Route::get('/new-arrival-management', [NewArrivalManagementController::class, 'index']) -> name('newam.homepage');
