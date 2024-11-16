<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

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



Route::get('sales/export', function () {
    return Excel::download(new SalesExport, 'sales.xlsx');
})->name('sales.export');


Route::resource('sales', SaleController::class);

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
