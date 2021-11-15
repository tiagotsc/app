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

/*Route::group(['middleware' => ['auth:web,api']], function () {
    Route::get('/abc', 'MyController@abc');
});*/

Route::group(['middleware' => ['auth:api', 'tokenValid']], function () {
    #http://127.0.0.1:8000/api/wallet/data?api_token=gNzR3YjMTgmHvrZVuqcnyEFdxY9g3yPejISVsnvrmsGoZWL6rlZm4B8Gqbcf
    Route::get('wallet/data/{id?}', 'WalletController@dataJson')->name('wallet_api.datajson');
    #http://127.0.0.1:8000/api/wallet/transactions?api_token=gNzR3YjMTgmHvrZVuqcnyEFdxY9g3yPejISVsnvrmsGoZWL6rlZm4B8Gqbcf
    Route::get('wallet/transactions', 'WalletController@allDataJson')->name('wallet_api.alldatajson');
    #http://127.0.0.1:8000/api/wallet/money/send/2?api_token=gNzR3YjMTgmHvrZVuqcnyEFdxY9g3yPejISVsnvrmsGoZWL6rlZm4B8Gqbcf
    Route::put('wallet/money/send/{origin}', 'WalletController@update')->name('wallet_api.update');
});
