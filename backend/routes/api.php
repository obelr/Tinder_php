<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PeopleController;

Route::get('/people', [PeopleController::class, 'index']);
Route::post('/people/{id}/like', [LikeController::class, 'like']);
Route::post('/people/{id}/dislike', [LikeController::class, 'dislike']);
Route::get('/liked', [LikeController::class, 'likedList']);

