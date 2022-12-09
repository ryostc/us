<?php

use App\Models\Instructor;
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

Route::get('/', function () {
    return view('welcome');
});

/**
 * テスト用GET
 */
Route::get('/ustest', 'App\Http\Controllers\UsController@index');

/**
 * テスト用POST
 */
Route::post('/ustest', 'App\Http\Controllers\UsController@post');

/**
 * インストラクターの一覧表示(instructors.blade.php)
 */
Route::get('/instructors/show', 'App\Http\Controllers\UsController@instructorShow');

/**
 * インストラクターの新規登録(get)
 */
Route::get('/instructors/register', 'App\Http\Controllers\UsController@index');

/**
 * インストラクターの新規追加(post)
 */
Route::post('/instructors/register', 'App\Http\Controllers\UsController@instructorRegister');

/**
 * インストラクターの削除
 */
Route::delete('/instructor/{instructor}', 'App\Http\Controllers\UsController@instructorDestroy');
