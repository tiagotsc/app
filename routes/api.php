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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# WALLET
Route::group(['middleware' => ['auth:api', 'tokenValid']], function () {
    Route::get('wallet/data/{id?}', 'WalletController@dataJson')->name('wallet_api.datajson');
    Route::get('wallet/transactions', 'WalletController@allDataJson')->name('wallet_api.alldatajson');
    Route::put('wallet/money/send/{origin}', 'WalletController@update')->name('wallet_api.update');
});
