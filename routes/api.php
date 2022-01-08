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
Route::prefix('test')->group(function () {
    Route::post('duplicate', 'Test1And2@duplicate')->name('duplicate');
    Route::post('bubble-sort', 'Test1And2@bubbleSort')->name('bubble-sort');
    
});

Route::prefix('auth')->group(function () {
    Route::post('login', 'UserController@login')->name('login');
    Route::post('register', 'UserController@register')->name('register');
    
});

Route::group(['middleware' => ['auth:api']], function(){
    Route::get('transactions', 'TransactionController@getByAuthId')->name('transactions');
    Route::post('top-up', 'TransactionController@topUp')->name('top-up');
    Route::post('with-draw', 'TransactionController@withDraw')->name('with-draw');

    Route::get('dana-user', 'DanaController@getByAuthId')->name('dana-user');

    Route::get('get-mutation', 'MutationController@index')->name('get-mutation');
    Route::post('transfer', 'MutationController@transfer')->name('transfer');

    Route::post('get-wallets', 'WalletController@getWallet')->name('get-wallets');
    Route::resource('wallets', 'WalletController')->only(['index','store','update','destroy']);

});
