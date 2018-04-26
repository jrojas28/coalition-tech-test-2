<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', 'TaskController@api__tasks');
Route::post('/tasks', 'TaskController@api__store');
Route::post('/tasks/update', 'TaskController@api__update');
Route::post('/projects', 'ProjectController@api__store');
Route::get('/projects/{project}/tasks', 'ProjectController@api__tasks');

