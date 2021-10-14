<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\BookmarkController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('jwt')->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{slug}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/posts/{slug}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    //Paieška
    Route::post("/search", [SearchController::class, 'search'])->name('search');
    //Balsavimas
    Route::delete('vote/{id}', [RatingController::class, 'remove'])->name('vote.remove');
    Route::post('/posts/{id}/vote', [RatingController::class, 'vote'])->name('vote');
    Route::post('sort', [RatingController::class, 'sort'])->name('sort');
    //Mėgstamiausi
    Route::get('/posts/{post}/bookmark', [BookmarkController::class, 'bookmark'])->name('bookmark');
    //Vartotojai
    Route::resource('user', API\UserController::class);
    //Istorija
    Route::get('history', [HistoryController::class, 'index'])->name('history');
    //Užsakymai
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('orders/{id}', [OrderController::class, 'view'])->name('orders.view');
    Route::post('orders/{slug}', [OrderController::class, 'store'])->name('orders.store');
    //AdminController
    Route::get('admin/users', [AdminController::class, 'index'])->name('admin');
    Route::get('admin/verify/user/{id}', [AdminController::class, 'verifyUser'])->name('admin.verify.user');
    Route::get('logout', [AuthController::class, 'logout']);
});
