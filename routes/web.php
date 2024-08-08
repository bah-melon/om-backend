<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function(Request $request){
    $token = $request->user()->createToken($request->token_name);
    
    return ['token' => $token->plainTextToken];
});