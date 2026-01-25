<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::livewire('dashboard', 'dashboard')
    ->name('dashboard');

require __DIR__.'/settings.php';
