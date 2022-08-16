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

// Route::get('/', [AccountController::class, 'home'])->name('home');

// Route::get('/login', [AccountController::class, 'home'])->name('login');

Route::get('/', [LoginController::class, 'login']) -> name('login');

Route::get('/login', [LoginController::class, 'login']) -> name('login');

Route::prefix('user-management')->group(function ()

{
    Route::get('/', [UsersManagementController::class, 'viewUM'])->name('honepage');

    Route::get('/add-user', [UsersManagementController::class, 'viewAddUser'])->name('adduser');

    Route::get('/modify-user', [UsersManagementController::class, 'viewModUser'])->name('modifyuser');

    Route::get('/detail-user', [UsersManagementController::class, 'viewDetailUser']) ->name('detailuser');

});


Route::get('/new-arrival-management', [NewArrivalManagementController::class, 'index']) -> name('NewAM');

Route::get('/work-space-management', [WorkSpaceManagementController::class,'index']) -> name('WorkSM');
