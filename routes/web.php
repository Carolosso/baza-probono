<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChildCrudController;
//use Backpack\CRUD\app\Library\Auth\backpack_auth;

Route::prefix(config('backpack.base.route_prefix'))->middleware(['web',backpack_middleware()])->group(function () {
    Route::get('2fa/setup', [TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::post('2fa/setup', [TwoFactorController::class, 'store'])->name('2fa.store');
    Route::get('2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify');
    Route::post('2fa/verify', [TwoFactorController::class, 'check'])->name('2fa.check');
});

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) 'web',
        (array) 'checkIfAdmin',
        (array) '2fa',
        (array) backpack_middleware(),
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { 
    Route::get('dashboard', [DashboardController::class,'show'])->name('admin.dashboard');
    Route::crud('child', 'ChildCrudController');
    Route::get('child/export-csvAll', [ChildCrudController::class, 'exportToCsvAll'])->name('child.export-csvAll');
    Route::get('child/export-csvChild', [ChildCrudController::class, 'exportToCsvChild'])->name('child.export-csvChild');
    Route::get('child/export-csvAdopter', [ChildCrudController::class, 'exportToCsvAdopter'])->name('child.export-csvAdopter');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('commandory', 'CommandoryCrudController');
    Route::crud('adopter', 'AdopterCrudController');
});
/* Route::prefix(config('backpack.base.route_prefix'))->middleware(['web','checkIfAdmin','2fa'])->group(function () {
    Route::get('dashboard', [DashboardController::class,'show'])->name('admin.dashboard');
    Route::crud('child', 'ChildCrudController');
    Route::get('child/export-csvAll', [ChildCrudController::class, 'exportToCsvAll'])->name('child.export-csvAll');
    Route::get('child/export-csvChild', [ChildCrudController::class, 'exportToCsvChild'])->name('child.export-csvChild');
    Route::get('child/export-csvAdopter', [ChildCrudController::class, 'exportToCsvAdopter'])->name('child.export-csvAdopter');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('commandory', 'CommandoryCrudController');
    Route::crud('adopter', 'AdopterCrudController');
}); */

Route::get('/', function () {
    return view('welcome');
});

