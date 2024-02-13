<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
use App\Models\Url;
use Illuminate\Routing\RouteGroup;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $urls = Url::where('user_id', auth()->id())->latest()->paginate(10);
    return view('dashboard', compact('urls'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //url
    Route::prefix('url')->as('url.')->group(function () {
        Route::post('submit', [UrlController::class, 'submit'])->name('submit');
        Route::get('click/{id}', [UrlController::class, 'click'])->name('click');
    });
});

require __DIR__ . '/auth.php';
