<?php

use Illuminate\Http\Request;
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

// インストラクターの新規登録画面
Route::get('/instructors/register', 'App\Http\Controllers\UsController@instructorRegister');

// インストラクターの新規登録処理
Route::post('/instructors/register', 'App\Http\Controllers\UsController@instructorCreate');

// インストラクターの一覧表示
Route::get('/instructors/show', 'App\Http\Controllers\UsController@instructorShow');

// インストラクターの更新画面
Route::get('/instructors/edit/{instructor}', 'App\Http\Controllers\UsController@instructorEdit');

// インストラクターの更新処理
Route::post('/instructors/update', 'App\Http\Controllers\UsController@instructorUpdate');

// インストラクターの削除
Route::delete('/instructor/{instructor}', 'App\Http\Controllers\UsController@instructorDestroy');
