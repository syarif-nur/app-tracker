<?php

use App\Livewire\DeliveryOrderManagement;
use App\Livewire\RoleManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', \App\Livewire\AppLayout    ::class)
        ->middleware('permission:can_view')
        ->name('dashboard');
    Route::get('/users', \App\Livewire\UserManagement::class)
        ->middleware('permission:can_view')
        ->name('users');
    Route::get('/roles', RoleManagement::class)->name('roles');
    Route::get('/delivery-orders', DeliveryOrderManagement::class)->name('delivery-orders');
    Route::get('/scan', \App\Livewire\ScanBarcode::class)->name('scan-barcode');
    Route::get('/logs', \App\Livewire\LogViewer::class)->name('logs');
    Route::get('/upload-proof', \App\Livewire\DeliveryOrderReceiptManagement::class)
        ->name('upload-proof');
});
