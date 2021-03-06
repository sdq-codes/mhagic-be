<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'ap1/v1'],function (){
    Route::get('',function (){
        return 'Welcome to Mhagic Api';
    });

    Route::group(['prefix' => 'auth'],function (){
        Route::post('/login','Auth\AuthController@login');
        Route::post('/register','Auth\AuthController@register');
        Route::post('/password/reset','Auth\AuthController@resetPasswordMail');
        Route::post('/reset','Auth\AuthController@resendVerification');
    });

    Route::group(['middleware' => ['auth:api']],function (){
        Route::put('/verify','Auth\AuthController@userVerification');
        Route::put('/password/reset','Auth\AuthController@passwordReset');

    });

    Route::get('/content', 'ContentController@fetchAll');
    Route::post('/wallet', 'ContentController@fundWallet');
    Route::post('/wallet/transfer', 'ContentController@transferTo');
    Route::get('/wallet', 'ContentController@fetchWallet');
    Route::get('/notifications', 'ContentController@notifications');
    Route::post('/vote', 'ContentController@vote');
    Route::post('/comment', 'ContentController@comment');
    Route::get('/contestant/{contestantId}', 'ContentController@contestant');
    Route::get('/follow/{contestantId}', 'ContentController@follow');
    Route::post('/profile', 'ContentController@profile');
    Route::get('/profile', 'ContentController@fetchProfile');
    Route::get('/block/{contestantId}', 'ContentController@block');
    Route::post('/report', 'ContentController@report');
    Route::post('/password', 'ContentController@report');

});

