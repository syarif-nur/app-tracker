<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Contoh route API dengan middleware permission
Route::middleware(['auth:sanctum', 'permission:can_view'])->get('/protected-view', function (Request $request) {
    return response()->json(['message' => 'You have view permission!', 'user' => $request->user()]);
});

Route::middleware(['auth:sanctum', 'permission:can_edit'])->post('/protected-edit', function (Request $request) {
    return response()->json(['message' => 'You have edit permission!', 'user' => $request->user()]);
});
