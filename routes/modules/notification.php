<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::middleware('auth')->get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::middleware('auth')->post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');