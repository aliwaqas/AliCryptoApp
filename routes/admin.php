<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::prefix('admin')->middleware('theme:admin')->name('admin.')->group(function () {

    Route::get('test', [App\Http\Controllers\SettingController::class, 'test'])->middleware('auth');
    // ----------------------------- Admin  Import -----------------------//
    Route::get('import/country', [App\Http\Controllers\SettingController::class, 'ImportCountry'])->middleware('auth:admin')->name('import.country');

    // ----------------------------- Admin  AuthManagement -----------------------//
    Route::view('/login', 'auth.login')->middleware('guest:admin')->name('login');
    $limiter = config('fortify.limiters.login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:admin',
            $limiter ? 'throttle:' . $limiter : null,
        ]));

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:admin')
        ->name('logout');

    Route::view('/home', 'dashboard.dashboard')->middleware('auth:admin')->name('home');

    // ----------------------------- Setting Managment -----------------------//
    Route::get('settings/country', [App\Http\Controllers\SettingController::class, 'index'])->middleware('auth:admin')->name('countrysetting');
    Route::get('settings/get-countrylist', [App\Http\Controllers\SettingController::class, 'getCountriesList'])->middleware('auth:admin')->name('get.countris.list');
    Route::post('settings/country', [App\Http\Controllers\SettingController::class, 'store'])->middleware('auth:admin')->name('addCountry');
    Route::post('settings/updatecountrydetails',[App\Http\Controllers\SettingController::class, 'updateCountryDetails'])->name('update.country.details');
    Route::post('settings/updatecountrystatus',[App\Http\Controllers\SettingController::class, 'updateCountryStatus'])->name('update.country.status');
    Route::post('settings/deletecountry',[App\Http\Controllers\SettingController::class,'deleteCountry'])->name('delete.country');


    // ----------------------------- user userManagement -----------------------//
    Route::get('userManagement', [App\Http\Controllers\UserManagementController::class, 'index'])->middleware('auth:admin')->name('userManagement');
    Route::get('user/get-users', [App\Http\Controllers\UserManagementController::class, 'getuserList'])->middleware('auth:admin')->name('get.user.list');
    Route::post('user/add/save', [App\Http\Controllers\UserManagementController::class, 'addNewUserSave'])->name('user/add/save');
    Route::post('update', [App\Http\Controllers\UserManagementController::class, 'update'])->name('update');
    Route::get('delete_user/{id}', [App\Http\Controllers\UserManagementController::class, 'delete'])->middleware('auth');
    Route::get('activity/log', [App\Http\Controllers\UserManagementController::class, 'activityLog'])->middleware('auth')->name('activity/log');
    Route::get('activity/login/logout', [App\Http\Controllers\UserManagementController::class, 'activityLogInLogOut'])->middleware('auth')->name('activity/login/logout');


});
