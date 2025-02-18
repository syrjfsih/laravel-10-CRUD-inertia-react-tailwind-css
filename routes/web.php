<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('posts', PostController::class)->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Baris yang ditambahkan adalah use App\Http\Controllers\PostController; dan Route::resource('posts', //PostController::class)->middleware(['auth', 'verified']);
//use App\Http\Controllers\PostController;: Ini adalah pernyataan yang mengimpor (menggunakan) kelas PostController yang //terletak dalam namespace App\Http\Controllers. Dengan cara ini, kita dapat menggunakannya dalam definisi rute tanpa harus //menuliskan namespace lengkapnya.
//Route::resource('posts', PostController::class)->middleware(['auth', 'verified']);: Ini adalah definisi rute yang melakukan beberapa hal:
//[-] Route::resource('posts', PostController::class): Ini menghasilkan berbagai rute standar yang diperlukan untuk //mengelola posting, seperti rute untuk menampilkan, membuat, menyimpan, mengedit, dan menghapus posting. Ini adalah metode //singkat untuk membuat rute CRUD (Create, Read, Update, Delete) dalam Laravel.
//[-] ->middleware(['auth', 'verified']): Middleware adalah filter yang digunakan untuk memproses permintaan sebelum //mencapai tindakan yang sesuai di PostController. Dalam hal ini, auth memastikan bahwa pengguna harus masuk (authenticated) //untuk mengakses rute-rute ini, dan verified memastikan bahwa pengguna juga harus memiliki email mereka diverifikasi //sebelum dapat menggunakannya.