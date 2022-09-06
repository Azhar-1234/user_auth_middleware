<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontEnd\SiteController;
use App\Http\Controllers\backEnd\DashBoardController;
use App\Http\Controllers\backEnd\UserController;
use App\Http\Controllers\backEnd\MonthlyController;
use App\Http\Controllers\backEnd\DoctorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[SiteController::class,'home']);
Auth::routes();

//user controller
Route::group(['middleware' => ['auth','admin']], function () {
	Route::get('/home',[DashBoardController::class,'index'])->name('home');
	Route::get('/view-user',[UserController::class,'view'])->name('view-user');
	Route::post('/store-user',[UserController::class,'store'])->name('store-user');
	Route::get('/edit-user/{id}',[UserController::class,'edit'])->name('edit-user');
	Route::post('/update-user',[UserController::class,'update'])->name('update-user');
	Route::get('/delete-user/{id}',[UserController::class,'delete'])->name('delete-user');
});
Route::group(['middleware' => ['auth','superadmin']], function () {
	Route::get('/monthly-cost',[MonthlyController::class,'view'])->name('monthly-cost');
});
Route::group(['middleware' => ['auth','doctor']], function () {
	Route::get('/medical-item',[DoctorController::class,'view'])->name('medical-item')->middleware('doctor');
});



