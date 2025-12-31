<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\GraveController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;






//Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('graves', GraveController::class);
//});



Route::get('/test-admin', function () {
    return 'admin ok';
})->middleware('auth','role:admin');





Route::get('/donation', function () {
    return view('dono');
})->name('dono');
Route::get('/maps', [VisitorController::class, 'index'])->name('visitor.index');
Route::get('/search', [VisitorController::class, 'search'])->name('visitor.search');
Route::get('/grave/{id}', [VisitorController::class, 'show'])->name('visitor.show');
Route::post('/clear-history', [VisitorController::class, 'clearHistory'])->name('visitor.clearHistory');

//Route::get('/', function () {
    //return view('welcome');
//});

Route::redirect('/', '/maps');

Route::get('/dashboard', fn () => redirect()->route('visitor.index'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
