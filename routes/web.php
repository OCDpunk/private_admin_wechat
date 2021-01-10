<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaPlatformController;

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
    return result(200,'服务已启动');
});

Route::any('/media-platform/{code}', [MediaPlatformController::class, 'service']);
