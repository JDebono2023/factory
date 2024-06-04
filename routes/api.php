<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

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


// Content version control
Route::get('/versiondata', [APIController::class, 'versionData']);
// http://127.0.0.1:8000/api/versiondata
// https://team.eyelookmedia.net/factory/api/versiondata

// Content all media
Route::get('/mediadata', [APIController::class, 'mediaData']);
// http://127.0.0.1:8000/api/mediadata
// https://team.eyelookmedia.net/factory/api/mediadata

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});