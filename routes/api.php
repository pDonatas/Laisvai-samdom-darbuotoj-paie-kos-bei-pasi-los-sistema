<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\BookmarkController;
use App\Http\Controllers\API\Categories\Bookmarks\PostUserBookmarksController;
use App\Http\Controllers\API\Categories\PostCategoryController;
use App\Http\Controllers\API\Categories\Votes\PostCategoryVotesController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\HistoryController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\Orders\PostOrderController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\UserController;
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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');

Route::middleware('jwt')->group(function () {
    //Skelbimai
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{slug}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/posts/{slug}', [PostController::class, 'update'])->name('posts.update');
    //Kategorijos
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::patch('/categories/{id}', [CategoryController::class, 'update'])->name('category.update');
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
    Route::get('/user/profile', [UserController::class, 'profile'])->name('profile');
    Route::resource('user', API\UserController::class);
    //Istorija
    Route::get('history', [HistoryController::class, 'index'])->name('history');
    //Užsakymai
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'view'])->name('orders.view');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    //AdminController
    Route::get('admin/users', [AdminController::class, 'index'])->name('admin');
    Route::get('admin/verify/user/{id}', [AdminController::class, 'verifyUser'])->name('admin.verify.user');
    Route::get('logout', [AuthController::class, 'logout']);
    //Lygiai
    //3 lvl
    Route::get('/categories/{category:id}/posts/{post:slug}/votes', [PostCategoryVotesController::class, 'index'])->name('posts.store');
    Route::post('/categories/{category:id}/posts/{post:slug}/votes', [PostCategoryVotesController::class, 'store'])->name('posts.store');
    Route::get('/categories/{category:id}/posts/{post:slug}/votes/{rating:id}', [PostCategoryVotesController::class, 'show'])->name('posts.show');
    Route::delete('/categories/{category:id}/posts/{post:slug}/votes/{rating:id}', [PostCategoryVotesController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/categories/{category:id}/posts/{post:slug}/votes/{rating:id}', [PostCategoryVotesController::class, 'update'])->name('posts.update');
    //Bookmarks
    Route::get('/users/{user:id}/posts/{post:slug}/bookmarks', [PostUserBookmarksController::class, 'index'])->name('posts.store');
    Route::post('/users/{user:id}/posts/{post:slug}/bookmarks', [PostUserBookmarksController::class, 'store'])->name('posts.store');
    Route::get('/users/{user:id}/posts/{post:slug}/bookmarks/{bookmark}', [PostUserBookmarksController::class, 'show'])->name('posts.show');
    Route::delete('/users/{user:id}/posts/{post:slug}/bookmarks/{bookmark}', [PostUserBookmarksController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/users/{user:id}/posts/{post:slug}/bookmarks/{bookmark}', [PostUserBookmarksController::class, 'update'])->name('posts.update');
    //2 lvl
    Route::get('/categories/{category:id}/posts', [PostCategoryController::class, 'index'])->name('posts.store');
    Route::post('/categories/{category:id}/posts', [PostCategoryController::class, 'store'])->name('posts.store');
    Route::get('/categories/{category:id}/posts/{slug}', [PostCategoryController::class, 'show'])->name('posts.show');
    Route::delete('/categories/{category:id}/posts/{slug}', [PostCategoryController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/categories/{category:id}/posts/{slug}', [PostCategoryController::class, 'update'])->name('posts.update');
    //Orders
    Route::get('/posts/{slug}/orders', [PostOrderController::class, 'index'])->name('orders');
    Route::get('/posts/{slug}/orders/{id}', [PostOrderController::class, 'view'] )->name('orders.view');
    Route::post('/posts/{slug}/orders', [PostOrderController::class, 'store'])->name('orders.store');
    Route::delete('/posts/{slug}/orders/{id}', [PostOrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('/posts/{slug}/orders/{id}', [PostOrderController::class, 'update'])->name('orders.update');
});
