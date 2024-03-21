<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeatControllers;
use App\Http\Controllers\Api\LikeControllers;
use App\Http\Controllers\Api\PostControllers;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// beat route

Route::get('/listeBeats', [BeatControllers::class, 'listeBeats'])->name('beats.liste');
Route::get('/beat/{slug}', [BeatControllers::class, 'getBeats'])->name('beats.get');
Route::post('/createBeat', [BeatControllers::class, 'createBeat'])->name('beats.create');
Route::get('/searchBeat', [BeatControllers::class, 'searchBeat'])->name('beats.search');
Route::delete('/deleteBeat/{uuid}', [BeatControllers::class, 'deleteBeat'])->name('beats.delete');
Route::patch('/like/{uuid}', [LikeControllers::class, 'like'])->name('beats.like');

// post route

Route::get('/listePosts', [PostControllers::class, 'listePost'])->name('post.liste');
Route::get('/post/{id}', [PostControllers::class, 'getPost'])->name('post.get');
Route::post('/createPost', [PostControllers::class, 'createPost'])->name('post.create');
Route::get('/searchPost', [PostControllers::class, 'searchPost'])->name('post.search');
Route::delete('/deletePost/{uuid}', [PostControllers::class, 'deletePost'])->name('post.delete');
Route::patch('/likePost{uuid}', [PostControllers::class, 'likePost'])->name('post.like');
