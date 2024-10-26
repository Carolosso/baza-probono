<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ChildCrudController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('child', 'ChildCrudController');
    Route::get('child/export-csvAll', [ChildCrudController::class, 'exportToCsvAll'])->name('child.export-csvAll');
    Route::get('child/export-csvChild', [ChildCrudController::class, 'exportToCsvChild'])->name('child.export-csvChild');
    Route::get('child/export-csvAdopter', [ChildCrudController::class, 'exportToCsvAdopter'])->name('child.export-csvAdopter');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('commandory', 'CommandoryCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
