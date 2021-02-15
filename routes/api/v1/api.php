<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users routes
Route::prefix('/user')->group(function(){
    Route::post('/login','api\v1\LoginController@login');
    // Access to API is possible with sending a Header with key Authorization and value 'Bearer AccessToken' 
    Route::middleware('auth:api')->get('/all', 'api\v1\user\UserController@index');
});