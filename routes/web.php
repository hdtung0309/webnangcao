<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-env', function () {
    dd(env('DB_USERNAME'), config('database.connections.mysql.username'));
});

Route::get('/', function () {
    return view('welcome');
});
