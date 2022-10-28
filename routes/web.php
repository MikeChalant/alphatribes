<?php

use App\Http\Controllers\Backend\AdminGroupController;
use App\Http\Controllers\Backend\AdminGroupUserController;
use App\Http\Controllers\Backend\AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GroupCategoryController;

Route::name('admin.')->prefix('admin')->middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::controller(AdminUserController::class)->group(function(){
        Route::get('admin-users', 'index')->name('user.index');
        Route::get('admin-users/create', 'create')->name('user.create');
        Route::post('admin-users', 'store')->name('user.store');
        Route::patch('admin-users/{id}', 'update')->name('user.update');
        Route::delete('admin-users/{id}', 'destroy')->name('user.delete');
        Route::get('admin-users/search', 'searchUser')->name('user.search');
    });
    Route::controller(CountryController::class)->group(function(){
        Route::get('countries', 'index')->name('country.index');
        Route::get('countries/create', 'create')->name('country.create');
        Route::post('countries', 'store')->name('country.store');
        Route::patch('countries/{id}', 'update')->name('country.update');
        Route::delete('countries/{id}', 'destroy')->name('country.delete');
        Route::get('countries/search', 'searchCountry')->name('country.search');

    });
    Route::controller(GroupCategoryController::class)->group(function(){
        Route::get('categories', 'index')->name('category.index');
        Route::get('categories/create', 'create')->name('category.create');
        Route::post('categories', 'store')->name('category.store');
        Route::patch('categories/{id}', 'update')->name('category.update');
        Route::delete('categories/{id}', 'destroy')->name('category.delete');
        Route::get('categories/search', 'searchCategory')->name('category.search');

    });
    Route::controller(AdminGroupController::class)->group(function(){
        Route::get('groups', 'index')->name('group.index');
        Route::get('groups/create', 'create')->name('group.create');
        Route::post('groups', 'store')->name('group.store');
        Route::get('groups/show/{id}', 'show')->name('group.show');
        Route::patch('groups/{id}', 'update')->name('group.update');
        Route::delete('groups/{id}', 'destroy')->name('group.delete');
        Route::get('groups/search', 'searchGroup')->name('group.search');
        Route::get('groups/block/{id}', 'block')->name('group.block');
        Route::get('groups/blocked', 'blockedGroup')->name('group.blocked');
        Route::get('groups/unblock/{id}', 'unblock')->name('group.unblock');
        Route::get('groups/payment-options/{id}', 'paymentOption')->name('group.payment_option');
        Route::patch('groups/payment-options/{id}', 'savePaymentOption')->name('group.save_payment_option');
        Route::get('groups/trial-period/{id}', 'createTrial')->name('group.create_trial');
        Route::patch('groups/trial-period/{id}', 'saveTrial')->name('group.save_trial');
        Route::get('groups/stripe-connect/{id}', 'createStripeConnect')->name('group.create_stripe_connect');
        Route::patch('groups/stripe-connect/{id}', 'saveStripeConnect')->name('group.save_stripe_connect');
        Route::get('groups/stripe-connect-success', 'stripeConnectSuccess')->name('group.stripe_connect_success');
    });
    Route::controller(AdminGroupUserController::class)->group(function(){
        Route::get('groups/users/add', 'create')->name('group_user.create');
    });
    Route::controller(AdminProfileController::class)->group(function(){
        Route::get('profile', 'index')->name('profile.index');
        Route::patch('profile/update', 'update')->name('profile.update');
        Route::patch('profile/change-password', 'changePassword')->name('profile.password');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard1');

require __DIR__.'/auth.php';
