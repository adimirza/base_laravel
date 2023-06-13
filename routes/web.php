<?php

use App\Http\Controllers\Api_example;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Login;
use App\Http\Controllers\Menu;
use App\Http\Controllers\MenuPermission;
use App\Http\Controllers\ProfilWeb;
use App\Http\Controllers\Role;
use App\Http\Controllers\RolePermission;
use App\Http\Controllers\User;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [Dashboard::class, 'index'])->middleware(['auth', 'permission:dashboard,read']);
Route::get('/', [Dashboard::class, 'index'])->middleware(['authSso']);
Route::get('/api_example', [Api_example::class, 'index']);

Route::get('/user', [User::class, 'index'])->middleware(['authSso']);
Route::get('/user/api', [User::class, 'api_user'])->middleware(['authSso']);
Route::match(['get', 'post'],'/user/add', [User::class, 'store'])->middleware(['authSso']);
Route::match(['get', 'post'],'/user/edit/{id}', [User::class, 'update'])->middleware(['authSso']);
Route::delete('/user/delete/{id}', [User::class, 'delete'])->middleware(['authSso']);

Route::get('/role', [Role::class, 'index'])->middleware(['authSso']);
Route::match(['get', 'post'],'/role/add', [Role::class, 'store'])->middleware(['authSso']);
Route::match(['get', 'post'],'/role/edit/{id}', [Role::class, 'update'])->middleware(['authSso']);
Route::delete('/role/delete/{id}', [Role::class, 'delete'])->middleware(['authSso']);

Route::get('/role_permission/{id}', [RolePermission::class, 'index'])->middleware(['authSso']);
Route::post('/role_permission/add', [RolePermission::class, 'store'])->middleware(['authSso']);

Route::get('/menu', [Menu::class, 'index'])->middleware(['authSso']);
Route::match(['get', 'post'],'/menu/add', [Menu::class, 'store'])->middleware(['authSso']);
Route::match(['get', 'post'],'/menu/edit/{id}', [Menu::class, 'update'])->middleware(['authSso']);
Route::post('/menu/status', [Menu::class, 'status'])->middleware(['authSso']);
Route::delete('/menu/delete/{id}', [Menu::class, 'delete'])->middleware(['authSso']);

Route::get('/menu_permission/{id}', [MenuPermission::class, 'index'])->middleware(['authSso']);
Route::post('/menu_permission/add', [MenuPermission::class, 'store'])->middleware(['authSso']);
Route::post('/menu_permission/status', [MenuPermission::class, 'status'])->middleware(['authSso']);
Route::get('/menu_permission/refresh/{id}', [MenuPermission::class, 'refresh'])->middleware(['authSso']);

Route::get('/profil_web', [ProfilWeb::class, 'index'])->middleware(['authSso']);
Route::post('/profil_web/edit', [ProfilWeb::class, 'update'])->middleware(['authSso']);
// Route::post('/profil_web/edit_image', [ProfilWeb::class, 'update_image'])->middleware(['auth', 'permission:profil web,update']);

Route::get('/reload-captcha', [Login::class, 'reloadCaptcha']);
Route::get('/login', [Login::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [Login::class, 'register'])->middleware('guest');
Route::post('/register/store', [Login::class, 'store'])->middleware('guest');
Route::post('/proses_login', [Login::class, 'proses_login']);
Route::get('/logout', [Login::class, 'logout']);
