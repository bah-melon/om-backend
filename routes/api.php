<?php

use App\Http\Controllers\Applicants\ApplicantsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OpenPosition\OpenPositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'credentialsLogin']);
    Route::get('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('reset-password', [AuthController::class, 'updatePassword']);

    // Authentication routes that require previously issued access token
    Route::middleware(['auth:api'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('open-positions')->group(function(){
        Route::get('/', [OpenPositionController::class, 'fetchPositions']);
        Route::get('/{openPosition}/applicants', [OpenPositionController::class, 'fetchApplicantsForPosition']);
        Route::post('/create', [OpenPositionController::class, 'store']);
        Route::get('/show/{openPosition}', [OpenPositionController::class, 'show']);
        Route::patch('/update/{openPosition}', [OpenPositionController::class, 'update']);
        Route::delete('/{openPosition}', [OpenPositionController::class, 'destroy']);
    });
    Route::prefix('applications')->group(function(){
        Route::get('/', [ApplicantsController::class, 'fetchApplications']);
        Route::post('/create', [ApplicantsController::class, 'store']);
        Route::get('/show/{applicant}', [ApplicantsController::class, 'show']);
        Route::delete('/{applicant}', [ApplicantsController::class, 'destroy']);
    });

});
