<?php

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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password-change', 'UserController@password_change')->name('password-change');
Route::post('/password-change', 'UserController@store_password')->name('store-password');
Route::get('/lt', function(){
    session(['user_locale' => 'lt']);
    return redirect()->back();
});
Route::get('/en', function(){
    session(['user_locale' => 'en']);
    return redirect()->back();
});
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/termsofservice', 'HomeController@termsofservice')->name('termsofservice');
Route::get('/posts/create', 'PostController@create')->name('posts.create');
Route::post('/posts/store', 'PostController@store')->name('posts.store');
Route::get('/posts/index', 'PostController@index')->name('posts.index');
Route::get('/posts/show', 'PostController@show')->name('posts.show');
Route::get('/posts/destroy', 'PostController@destroy')->name('posts.destroy');
Route::get('/posts/edit', 'PostController@edit')->name('posts.edit');
Route::get('/posts/update', 'PostController@update')->name('posts.update');
