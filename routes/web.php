<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    if(Auth::id()){
        return view('dashboard');
    }else{
        return view('auth.login');
    }

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function(){

    # USER
    Route::resource('/users', 'UserController')->middleware('can:users.manager');
    Route::get('user/datajson/{id?}', 'UserController@dataJson')->name('user.datajson')->middleware('can:users.manager');
    Route::get('user/alldatajson', 'UserController@allDataJson')->name('user.alldatajson')->middleware('can:users.manager');

    # PERMISSION
    Route::resource('/permissions', 'PermissionController')->middleware('can:permissions.manager');
    Route::get('permission/datajson/{id?}', 'PermissionController@dataJson')->name('permission.datajson')->middleware('can:permissions.manager');
    Route::get('permission/alldatajson', 'PermissionController@allDataJson')->name('permission.alldatajson')->middleware('can:permissions.manager');

    # ROLE
    Route::resource('/roles', 'RoleController')->middleware('can:roles.manager');
    Route::get('role/datajson/{id?}', 'RoleController@dataJson')->name('role.datajson')->middleware('can:roles.manager');
    Route::get('role/alldatajson', 'RoleController@allDataJson')->name('role.alldatajson')->middleware('can:roles.manager');

    # WALLET
    Route::get('wallet', 'WalletController@index')->name('wallet.index');
    Route::get('wallet/edit', 'WalletController@edit')->name('wallet.edit');
    Route::get('wallet/datajson/{idWallet?}', 'WalletController@dataJson')->name('wallet.datajson');
    Route::get('wallet/alldatajson', 'WalletController@allDataJson')->name('wallet.alldatajson');
    Route::put('wallet/money/send/{origin}', 'WalletController@update')->name('wallet.update');

});

require __DIR__.'/auth.php';
