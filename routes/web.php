<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// インストラクターの新規登録画面
Route::get('/instructors/register', 'App\Http\Controllers\UsController@instructorRegister');

// インストラクターの新規登録処理
Route::post('/instructors/register', 'App\Http\Controllers\UsController@instructorCreate');

// インストラクターの一覧表示
Route::get('/instructors/show', 'App\Http\Controllers\UsController@instructorShow');

// インストラクターの詳細表示
Route::get('/instructors/detail/{instructor}', 'App\Http\Controllers\UsController@instructorDetailShow');

// インストラクターの更新画面
Route::get('/instructors/edit/{instructor}', 'App\Http\Controllers\UsController@instructorEdit');

// インストラクターの更新処理
Route::post('/instructors/update', 'App\Http\Controllers\UsController@instructorUpdate');

// インストラクターの削除
Route::delete('/instructor/{instructor}', 'App\Http\Controllers\UsController@instructorDestroy');

// 生徒の新規登録画面
Route::get('/students/register', 'App\Http\Controllers\UsController@studentRegister');

// 生徒の新規登録処理
Route::post('/students/register', 'App\Http\Controllers\UsController@studentCreate');

// 生徒の一覧表示
Route::get('/students/show', 'App\Http\Controllers\UsController@studentShow');

// 生徒の詳細表示
Route::get('/students/detail/{student}', 'App\Http\Controllers\UsController@studentDetailShow');

// 生徒の更新画面
Route::get('/students/edit/{student}', 'App\Http\Controllers\UsController@studentEdit');

// 生徒の更新処理
Route::post('/students/update', 'App\Http\Controllers\UsController@studentUpdate');

// 生徒の削除
Route::delete('/student/{student}', 'App\Http\Controllers\UsController@studentDestroy');
