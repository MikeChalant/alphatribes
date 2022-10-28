<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\GroupMemberController;

Route::prefix('v1')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('confirm-phone', [AuthController::class, 'confirmPhone']);
    Route::post('confirm-phone/resend', [AuthController::class, 'resendConfirmPhone']);

    // Routes with authentication
    Route::middleware('auth:api')->group(function(){
        Route::controller(UserController::class)->group(function(){
            Route::post('settings/profile', 'store');
        });

        //Group Routes
        Route::controller(GroupController::class)->group(function(){
            Route::get('groups/categories', 'groupCategories');
            Route::post('groups', 'store');
            Route::post('groups/payment-option/{id}', 'savePaymentOption');
            Route::post('groups/trial-period/{id}', 'saveTrial');
            Route::post('groups/stripe-connect/{id}', 'saveStripeConnect');
            Route::post('groups/members', 'addMembers');
            Route::get('groups/search', 'search');
        });

        //Group Member Routes
        Route::controller(GroupMemberController::class)->group(function(){
            Route::post('groups/members', 'addMembers');
            Route::post('groups/members/join-free', 'joinFreeGroup');
            Route::post('groups/members/join-paid', 'joinPaidGroup');
        });

        //Messages Route
        Route::controller(MessageController::class)->group(function(){
            Route::post('messages', 'store');
        });
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
