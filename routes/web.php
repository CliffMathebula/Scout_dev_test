<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'blogsController@show_blogs');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('checklogin', 'LoginController@login');

//route to edit user details 
Route::get('edit_user/{id}', 'UsersController@select');

//route to update user details 
Route::get('update_details', 'UsersController@update');

//route to select edited blog post 
Route::get('edit_post/{id}', 'blogsController@select_post');

//route to update blog post 
Route::get('post_update', 'blogsController@update_post');

//route to post blog post 
Route::get('post_blog', 'blogsController@blog_post');

//route to post blog post 
Route::get('create_post', 'blogsController@create_post');

//route to delete blog post 
Route::get('delete_post/{post_id}', 'blogsController@destroy');

//route to rate post 
Route::get('rate_post/{rate_value}/{post_id}/{rate}', 'blogsController@rate_post');




