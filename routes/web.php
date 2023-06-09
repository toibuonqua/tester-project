<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WorkSpaceManagementController;
use App\Http\Controllers\NewArrivalManagementController;
use App\Http\Controllers\PasswordDefaultController;
use App\Http\Controllers\ResetAdminController;
use App\Http\Controllers\Api\UsersManagementController as ApiUsersManagementController;
use App\Models\DefaultPassword;
use App\Models\Role;

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

Route::post('/', [LoginController::class, 'checkLogin'])->name('auth.login');

Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');

Route::get('/info-account', [LoginController::class, 'infoAccount'])->name('account.info');

Route::get('/change_pw', [UsersManagementController::class, 'changePassword'])->name('account.changepw');

Route::post('/change_pw', [UsersManagementController::class, 'passwordUpdate'])->name('password.update');

Route::post('/change_pw/user_password', [ApiUsersManagementController::class, 'checkPasswordUser'])->name('password.user');

Route::get('/notice-login', [UsersManagementController::class, 'noticeLogin'])->name('back.login');

Route::get('/reset-admin', [ResetAdminController::class, 'index'])->name('ra.index');

Route::get('/reset-admin/confirm', [ResetAdminController::class, 'confirm'])->name('ra.confirm');

Route::prefix('user')->middleware('check.admin')->group(function ()
{
    Route::get('/', [UsersManagementController::class, 'index'])->name('homepage');

    Route::get('/search', [UsersManagementController::class, 'search'])->name('user.search');

    Route::get('/export', [UsersManagementController::class, 'export'])->name('user.export');

    Route::get('/add', [UsersManagementController::class, 'add'])->name('user.add');

    Route::post('/add', [UsersManagementController::class, 'store'])->name('user.store');

    Route::get('/modify/{id}', [UsersManagementController::class, 'modify'])->name('user.modify');

    Route::get('/detail/{id}', [UsersManagementController::class, 'detail'])->name('user.detail');

    Route::post('/modify/{id}', [UsersManagementController::class, 'update'])->name('user.update');

    Route::get('/active/{id}', [UsersManagementController::class, 'active'])->name('user.active');

    Route::get('/reset_pw/{id}', [UsersManagementController::class, 'resetpw'])->name('user.resetpw');

});


Route::prefix('work-space-management')->middleware('check.admin')->group( function()
{

    Route::get('/', [WorkSpaceManagementController::class,'index']) -> name('worksm.homepage');

    Route::get('/search', [WorkSpaceManagementController::class, 'search'])-> name('worksm.search');

    Route::get('/export', [WorkSpaceManagementController::class, 'export'])-> name('worksm.export');

    Route::get('/add', [WorkSpaceManagementController::class,'add']) -> name('worksm.add');

    Route::post('/add', [WorkSpaceManagementController::class, 'store'])-> name('worksm.store');

    Route::get('/delete/{id}', [WorkSpaceManagementController::class,'delete']) -> name('worksm.delete');

    Route::get('/modify/{id}', [WorkSpaceManagementController::class,'modify']) -> name('worksm.modify');

    Route::post('/modify/{id}', [WorkSpaceManagementController::class, 'update']) -> name('worksm.update');

    Route::get('/detail/{id}', [WorkSpaceManagementController::class,'detail']) -> name('worksm.detail');

    Route::get('/info-creater/{id}', [WorkSpaceManagementController::class, 'infoCreater']) -> name('info.user');

});

Route::prefix('department')->middleware('check.admin')->group( function()
{

    Route::get('/', [DepartmentController::class, 'index'])->name('department.homepage');

    Route::get('/add', [DepartmentController::class, 'add'])->name('department.add');

    Route::post('/add', [DepartmentController::class, 'store'])->name('department.store');

    Route::get('/modify/{id}', [DepartmentController::class, 'modify'])->name('department.modify');

    Route::post('/modify/{id}', [DepartmentController::class, 'update'])->name('department.update');

    Route::get('/detail/{id}', [DepartmentController::class, 'detail'])->name('department.detail');

    Route::get('/delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');

    Route::get('/search', [DepartmentController::class, 'search'])->name('department.search');

    Route::get('/export', [DepartmentController::class, 'export'])->name('department.export');

});

Route::prefix('default-password')->middleware('check.admin')->group( function()
{

    Route::get('/', [PasswordDefaultController::class, 'modify'])->name('dfpassword');

    Route::post('/update', [PasswordDefaultController::class, 'update'])->name('dfpassword.update');

});

Route::get('/new-arrival-management', [NewArrivalManagementController::class, 'index']) -> name('newam.homepage');
