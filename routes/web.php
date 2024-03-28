<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\YourController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
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

Route::get('/',[HomeController::class, 'index']);
Route::post('/addproduct',[HomeController::class, 'addproduct'])->name('addproduct');
Route::get('/produitfemme',[HomeController::class, 'produitfemme'])->name('produitfemme');
Route::get('/produithomme',[HomeController::class, 'produithomme'])->name('produithomme');
Route::get('/produitenfant',[HomeController::class, 'produitenfant'])->name('produitenfant');
Route::get('/add', function () {return view('addproduct');});
Route::get('/afficherpro/{id}', [HomeController::class, 'afficherpro'])->name('afficherpro');
Route::post('/redirect', [ProfileController::class, 'redirect'])->name('redirect');
Route::post('/costumercallback', [ProfileController::class, 'costumercallback'])->name('payment.costumercallback')->secure();
Livewire::component('CartIcon', \App\Livewire\CartIcon::class);


Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/afficheritems', [HomeController::class, 'afficheritems'])->secure();
    Route::get('/delete/{id}', [HomeController::class, 'delete'])->name('delete');
    Route::post('/addcommande/{id}',[HomeController::class, 'addcommande'])->name('addcommande')->secure();
    Route::post('/payment',[ProfileController::class, 'payment'])->name('payment')->secure();
});