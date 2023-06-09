<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
 
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

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


 Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminController::class ,'Admindashboard'])->name('admin.dashboard'); 
    Route::get('/admin/logout',[AdminController::class ,'Admindestroy'])->name('admin.logout'); 
    Route::get('/admin/profile',[AdminController::class ,'Adminprofile'])->name('admin.profile'); 
    Route::post('/admin/profile/store',[AdminController::class ,'AdminProfileStore'])->name('admin.profile.store'); 
    Route::get('/admin/change/password',[AdminController::class ,'AdminChangePassword'])->name('admin.change.password'); 
    Route::post('/admin/update/password',[AdminController::class ,'AdminUpdatePassword'])->name('admin.update.password'); 
 });


 
 Route::middleware(['auth','role:vendor'])->group(function(){
    Route::get('/vendor/dashboard',[vendorController::class ,'Vendordashboard'])->name('vendor.dashboard'); 
    Route::get('/vendor/logout',[vendorController::class ,'Vendordestroy'])->name('vendor.logout'); 
    Route::get('/vendor/profile',[vendorController::class ,'Vendorprofile'])->name('vendor.profile'); 
    Route::post('/vendor/profile/store',[vendorController::class ,'VendorProfileStore'])->name('vendor.profile.store'); 



 });


 //no auth
 Route::get('/admin/login',[AdminController::class ,'Adminlogin']); 
 Route::get('/vendor/login',[vendorController::class ,'Vendorlogin']); 




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
