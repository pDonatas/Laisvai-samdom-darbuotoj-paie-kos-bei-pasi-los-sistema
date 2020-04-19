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

Route::get('/', 'GuestController@home');
Route::get('/home', 'GuestController@home')->name('home');
Auth::routes();
Route::get('/password-change', 'UserController@password_change')->name('password-change');
Route::post('/password-change', 'UserController@store_password')->name('store-password');
Route::get('/lt', function(){
    session(['user_locale' => 'lt']);
    return redirect()->back();
})->name('lt');
Route::get('/en', function(){
    session(['user_locale' => 'en']);
    return redirect()->back();
})->name('en');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/termsofservice', 'HomeController@termsofservice')->name('termsofservice');
Route::get('/posts/create', 'PostController@create')->name('posts.create');
Route::post('/posts/store', 'PostController@store')->name('posts.store');
Route::get('/posts/index', 'PostController@index')->name('posts.index');
Route::get('/posts/show/{slug}', 'PostController@show')->name('posts.show');
Route::delete('/posts/destroy/{slug}', 'PostController@destroy')->name('posts.destroy');
Route::get('/posts/edit/{slug}', 'PostController@edit')->name('posts.edit');
Route::patch('/posts/update/{slug}', 'PostController@update')->name('posts.update');
Route::get('/categories', 'CategoryController@index')->name('categories');
Route::post('/createcategory', 'CategoryController@store')->name('category.store');
Route::put('/update/{id}', 'CategoryController@update')->name('category.update');
Route::delete('/delete/{id}', 'CategoryController@destroy')->name('category.destroy');
Route::get('/contacts', 'GuestController@index') ->name('contacts');
Route::post('/contacts', 'GuestController@contactform')->name(('contactform'));
Route::get('/privacypolicy', 'GuestController@privacypolicy')->name('privacypolicy');
