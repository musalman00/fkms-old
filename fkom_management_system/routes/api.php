<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\KioskController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\UserPaymentsController;
use App\Http\Controllers\Api\KioskParticipantController;
use App\Http\Controllers\Api\UserApplicationsController;
use App\Http\Controllers\Api\KioskApplicationsController;
use App\Http\Controllers\Api\UserKioskParticipantsController;
use App\Http\Controllers\Api\KioskKioskParticipantsController;
use App\Http\Controllers\Api\KioskParticipantComplaintsController;
use App\Http\Controllers\Api\KioskParticipantPromotionsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('applications', ApplicationController::class);

        Route::apiResource('complaints', ComplaintController::class);

        Route::apiResource('kiosks', KioskController::class);

        // Kiosk Applications
        Route::get('/kiosks/{kiosk}/applications', [
            KioskApplicationsController::class,
            'index',
        ])->name('kiosks.applications.index');
        Route::post('/kiosks/{kiosk}/applications', [
            KioskApplicationsController::class,
            'store',
        ])->name('kiosks.applications.store');

        // Kiosk Kiosk Participants
        Route::get('/kiosks/{kiosk}/kiosk-participants', [
            KioskKioskParticipantsController::class,
            'index',
        ])->name('kiosks.kiosk-participants.index');
        Route::post('/kiosks/{kiosk}/kiosk-participants', [
            KioskKioskParticipantsController::class,
            'store',
        ])->name('kiosks.kiosk-participants.store');

        Route::apiResource(
            'kiosk-participants',
            KioskParticipantController::class
        );

        // KioskParticipant Complaints
        Route::get('/kiosk-participants/{kioskParticipant}/complaints', [
            KioskParticipantComplaintsController::class,
            'index',
        ])->name('kiosk-participants.complaints.index');
        Route::post('/kiosk-participants/{kioskParticipant}/complaints', [
            KioskParticipantComplaintsController::class,
            'store',
        ])->name('kiosk-participants.complaints.store');

        // KioskParticipant Promotions
        Route::get('/kiosk-participants/{kioskParticipant}/promotions', [
            KioskParticipantPromotionsController::class,
            'index',
        ])->name('kiosk-participants.promotions.index');
        Route::post('/kiosk-participants/{kioskParticipant}/promotions', [
            KioskParticipantPromotionsController::class,
            'store',
        ])->name('kiosk-participants.promotions.store');

        Route::apiResource('payments', PaymentController::class);

        Route::apiResource('promotions', PromotionController::class);

        Route::apiResource('users', UserController::class);

        // User Applications
        Route::get('/users/{user}/applications', [
            UserApplicationsController::class,
            'index',
        ])->name('users.applications.index');
        Route::post('/users/{user}/applications', [
            UserApplicationsController::class,
            'store',
        ])->name('users.applications.store');

        // User Kiosk Participants
        Route::get('/users/{user}/kiosk-participants', [
            UserKioskParticipantsController::class,
            'index',
        ])->name('users.kiosk-participants.index');
        Route::post('/users/{user}/kiosk-participants', [
            UserKioskParticipantsController::class,
            'store',
        ])->name('users.kiosk-participants.store');

        // User Payments
        Route::get('/users/{user}/payments', [
            UserPaymentsController::class,
            'index',
        ])->name('users.payments.index');
        Route::post('/users/{user}/payments', [
            UserPaymentsController::class,
            'store',
        ])->name('users.payments.store');
    });
