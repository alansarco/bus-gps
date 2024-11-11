<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Models\Admin;
use App\Http\Controllers\DataController;
use App\Http\Controllers\MapController;

Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin'])->group(function(){
        Route::view('/login','back.pages.admin.auth.login')->name('login');
        Route::post('/login_handler',[AdminController::class,'loginHandler'])->name('login_handler');
    });

    Route::middleware(['auth:admin'])->group(function(){
        Route::post('/logout_handler',[AdminController::class,'logoutHandler'])->name('logout_handler');
        Route::get('/profile',[AdminController::class,'profileView'])->name('profile');
        Route::get('/home',[AdminController::class,'homeView'])->name('home');
        Route::get('/import',[AdminController::class,'importView'])->name('import');
        Route::post('/import',[DataController::class,'importData'])->name('import-data');
        Route::get('/location/{encryptedId}', [MapController::class, 'showLocation'])->name('show');    

        //Route sa crud customer add,edit,view,delete

        // Route::controller(DataController::class)->group(function(){
        //     Route::get('/customer','orderCustomer')->name('order-customer');
        //     Route::get('/create-customer','createCustomer')->name('create-customer');
        //     Route::post('/create-customer','storeCustomer')->name('store-customer');
        //     Route::post('/customer','deleteCustomer')->name('delete-customer');
        //     Route::post('/done-customer','doneCustomer')->name('done-customer');
        //     Route::post('/paid-customer','paidCustomer')->name('paid-customer');

            //History & Cancelled
            // Route::get('/history','viewHistory')->name('order-history');
            // Route::get('/cancelled','viewCancelled')->name('order-cancelled');

        // });
        //Profile
        Route::controller(AdminController::class)->group(function(){
            Route::get('/accounts','viewAccounts')->name('account-user');
            Route::post('/create-account','storeAccount')->name('store-account');
            Route::post('/update-account','updateAccount')->name('update-account');
            Route::post('/accounts','deleteAccount')->name('delete-account');
            // Route::post('/create-customer','store-customer')->name('store-customer');
        });
    });
});