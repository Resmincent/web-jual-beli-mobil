<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');



Route::resource('brands', BrandController::class);

Route::resource('categories', CategoryController::class);

Route::resource('vehicles', VehicleController::class);

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::get('/vehicle/{id}/order', action: [LandingPageController::class, 'order'])->name('order');

Route::get('/redirect-user', function () {
    if (Auth::check() && !Auth::user()->is_admin) {
        return redirect()->route('landing');
    }
    return redirect()->route('home');
})->middleware('auth');
