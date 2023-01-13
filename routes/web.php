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

// インストラクターの削除
Route::POST('/instructor/remove', 'App\Http\Controllers\UsController@instructorRemove');

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
Route::post('/student/remove', 'App\Http\Controllers\UsController@studentRemove');

// 生徒の検索画面
Route::get('/students/search', 'App\Http\Controllers\UsController@studentSearchScreen');

// 生徒の検索処理
Route::post('/students/search', 'App\Http\Controllers\UsController@studentSearch');

// 生徒の管理画面
Route::get('/students/control', 'App\Http\Controllers\UsController@studentControl');

// スケジュールの管理画面
Route::get('/schedules/control', 'App\Http\Controllers\UsController@scheduleControl');

// スケジュールの管理画面
Route::get('/schedules/basic/{ym}/{j}', 'App\Http\Controllers\UsController@scheduleBasic');

// スケジュールの新規登録画面(生徒情報を入れる前)
Route::get('/schedules/register/{date}/{time}', 'App\Http\Controllers\UsController@scheduleRegister');

// スケジュールの新規登録の生徒検索画面
Route::POST('/schedules/register/search', 'App\Http\Controllers\UsController@scheduleRegisterSearch');

// スケジュールの新規登録の生徒検索処理結果の表示
Route::POST('/schedules/register/searchResult', 'App\Http\Controllers\UsController@scheduleRegisterSearchResult');

// スケジュールの新規登録画面(生徒情報を入れた後)
Route::GET('/schedules/register/createScreen/{student_id}/{date}/{time}', 'App\Http\Controllers\UsController@scheduleCreateScreen');

// スケジュールの新規登録処理
Route::POST('/schedules/register/create', 'App\Http\Controllers\UsController@scheduleCreate');

// スケジュールの更新画面
Route::GET('/schedules/edit/screen/{schedule_id}', 'App\Http\Controllers\UsController@scheduleEditScreen');

// スケジュールの更新処理
Route::POST('/schedules/edit', 'App\Http\Controllers\UsController@scheduleEdit');

// スケジュールの更新処理
Route::POST('/schedules/remove', 'App\Http\Controllers\UsController@scheduleRemove');

// 生徒ごとのスケジュールの詳細表示(新規登録からの遷移)
Route::POST('/schedules/studentDetail1', 'App\Http\Controllers\UsController@scheduleStudetDetail1');

// 生徒ごとのスケジュールの詳細表示(更新からの遷移)
Route::POST('/schedules/studentDetail2', 'App\Http\Controllers\UsController@scheduleStudetDetail2');

// 指定した月の未予約生徒の表示
Route::GET('/schedules/unreservedStudent', 'App\Http\Controllers\UsController@unreservedStudent');