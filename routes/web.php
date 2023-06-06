<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Models\Chat;
use App\Models\User;
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

Route::get('/users', function () {
    return Inertia::render('UsersList', [
        'users' => User::all(),
    ]);
})->middleware(['auth', 'verified'])->name('users');

Route::get('/chats', function () {
    return Inertia::render('ChatsList', [
        // 'chats' => Chat::all()->filter(function($chat) {
        //     $users = $chat->users;
        //     foreach($users as $user) {
        //         if($user->id === request()->user()->id) {
        //             return true;
        //         }
        //     }
        //     return false;
        // }),
        'chats' => User::find(request()->user()->id)->chats()->with(['users'])->get(),
        // 'chats' => Chat::all()->where('users.id', request()->user()->id),
    ]);
})->middleware(['auth', 'verified'])->name('chats');

Route::post('/chats', [ChatController::class, 'openOrCreate'])->middleware(['auth', 'verified'])->name('open.or.create.chat');

// Route::get('/chats/{id}', [ChatController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/chats/{id}', [ChatController::class, 'index'])->middleware(['auth', 'verified'])->name('chat');

Route::post('/chats/{id}', [ChatController::class, 'store'])->middleware(['auth', 'verified'])->name('store-message');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
