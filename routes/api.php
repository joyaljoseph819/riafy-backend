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

Route::post('login','AuthController@login');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('verifyToken','AuthController@verifyToken');
    Route::post('search','SearchController@getSearchResult');
    Route::post('fetchResult','SearchController@getFetchResult');
    Route::post('logout','AuthController@logout');
});