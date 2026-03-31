<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('home'))->name('home');
Route::get('/login', function () {
    return 'Halaman login belum dibuat boz';
})->name('login');

Route::get('/register', function () {
    return 'Halaman register belum dibuat boz';
})->name('register');