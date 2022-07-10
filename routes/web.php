<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppUserController;
use App\Http\Controllers\AppUserDashboardController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\SectionsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth', 'verified','role:admin'])->prefix('admin')->group(function(){

    Route::get('users', [ManageUserController::class,'index'])->name('user-index');

    Route::get('/adminhome',[AdminController::class,'index'])->name('admin-home');

    Route::resource('sections', SectionsController::class);

    Route::resource('questions',QuestionsController::class)->only(['show','destroy']);

    Route::get('questions/create/{section}', [QuestionsController::class, 'create'])->name('questions.create');

    Route::post('questions/store/{section}', [QuestionsController::class, 'store'])->name('questions.store');
});

Route::middleware(['auth','verified','role:admin|user'])->prefix('appuser')->group(function(){

    Route::get('/userQuizHome',AppUserDashboardController::class)->name('userQuizHome');

    Route::resource('quiz', AppUserController::class)->only(['create','show', 'destroy']);
});
