<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return redirect('/admin/login');
    return view('welcome');
});
Route::resource('children', PostController::class)->middleware('permission:view|edit|delete');

