<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeleskeController;
use App\Http\Controllers\ObavestenjeController;
use App\Http\Controllers\PodsetnikController;
use App\Http\Controllers\StatistikaController;
use App\Http\Controllers\ZadatakController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')-> group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::get('/zadaci/{id}', [ZadatakController::class,'show']);
Route::get('/zadaci', [ZadatakController::class,'index']);
Route::middleware('auth:sanctum')-> group(function(){
    Route::post('/zadaci', [ZadatakController::class,'store']);
    Route::delete('/zadaci/{id}', [ZadatakController::class,'destroy']);
    Route::put('/zadaci/{id}', [ZadatakController::class,'update']);
});

Route::get('/beleske/{id}', [BeleskeController::class,'show']);
Route::get('/beleske', [BeleskeController::class,'index']);
Route::middleware('auth:sanctum')-> group(function(){
    Route::post('/beleske', [BeleskeController::class,'store']);
    Route::delete('/beleske/{id}', [BeleskeController::class,'destroy']);
    Route::put('/beleske/{id}', [BeleskeController::class,'update']);
});

Route::get('/obavestenje/{id}', [ObavestenjeController::class,'show']);
Route::get('/obavestenje', [ObavestenjeController::class,'index']);
Route::middleware('auth:sanctum')-> group(function(){
    Route::post('/obavestenje', [ObavestenjeController::class,'store']);
    Route::delete('/obavestenje/{id}', [ObavestenjeController::class,'destroy']);
    Route::put('/obavestenje/{id}', [ObavestenjeController::class,'update']);

});

Route::get('/podsetnik/{id}', [PodsetnikController::class,'show']);
Route::get('/podsetnik', [PodsetnikController::class,'index']);
Route::middleware('auth:sanctum')-> group(function(){
    Route::post('/podsetnik', [PodsetnikController::class,'store']);
    Route::delete('/podsetnik/{id}', [PodsetnikController::class,'destroy']);
    Route::put('/podsetnik/{id}', [PodsetnikController::class,'update']);
});

Route::get('/statistika/{id}', [StatistikaController::class,'show']);
Route::get('/statistika', [StatistikaController::class,'index']);
Route::middleware('auth:sanctum')-> group(function(){
    Route::post('/statistika', [StatistikaController::class,'store']);
    Route::delete('/statistika/{id}', [StatistikaController::class,'destroy']);
    Route::put('/statistika/{id}', [StatistikaController::class,'update']);
});






