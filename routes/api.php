<?php

use Illuminate\Http\Request;

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
Route::post('/register', 'JWTAuthController@register');
Route::post('/login', 'JWTAuthController@login');

Route::group(['middleware' => 'auth:api'], function () {

    Route::apiResource('/posts', 'PostController');
    Route::post('/posts/showPosts', 'PostController@showPosts');
    Route::post('/posts/userPosts', 'PostController@userPosts');
    Route::post('/posts/likePosts', 'PostController@likePosts');

    Route::get('/user', 'JWTAuthController@user');
    Route::get('/refresh', 'JWTAuthController@refresh');
    Route::get('/logout', 'JWTAuthController@logout');

    Route::post('/createComment', 'PostCommentController@store');
    Route::post('/showComment', 'PostCommentController@show');

    Route::post('/posts/favorites', 'FavoriteController@store');
    Route::post('/posts/unfavorites', 'FavoriteController@destroy');
    Route::post('/posts/hasFavorites', 'FavoriteController@hasFavorite');
    Route::post('/showLikeUsers', 'FavoriteController@show');

    Route::post('/editProfile', 'UserController@editProfile');
    Route::post('/search', 'UserController@search');
    Route::post('/user', 'UserController@user');
    Route::post('/user/follow/', 'UserController@followingUser');
    Route::post('/user/followed', 'UserController@followedUser');
    
    Route::post('/follow', 'FollowController@follow');
    Route::post('/unfollow', 'FollowController@unfollow');

});
