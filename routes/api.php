<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Books\BooksController;
use App\Http\Controllers\Videos\VideosController;
use App\Http\Controllers\Devices\DevicesController;
use App\Http\Controllers\ExportVideosExcelController;
use App\Http\Controllers\ExportBooksExcelController;
use App\Http\Controllers\ExportDevicesExcelController;
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
Route::group([], function ($router) {
    
    /**
     * Authentication Module
     */
    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
    

    /**
     * Books Module
     */
    Route::resource('books', BooksController::class);
    Route::get('books/view/all', [BooksController::class, 'indexAll']);
    Route::get('books/view/search', [BooksController::class, 'search']);

    /**
     * Videos Module
     */
    Route::resource('videos', VideosController::class);
    Route::get('videos/view/all', [VideosController::class, 'indexAll']);
    Route::get('videos/view/search', [VideosController::class, 'search']);
    
    /**
     * Devices Module
     */
    Route::resource('devices', DevicesController::class);
    Route::get('devices/view/all', [DevicesController::class, 'indexAll']);
    Route::get('devices/view/search', [DevicesController::class, 'search']);

    /**
     * Get client IP
     */
    Route::get('/ip','App\Http\Controllers\Controller@getIp');
    Route::get('/uptime','App\Http\Controllers\Controller@upTime');
    Route::get('/announcement','App\Http\Controllers\Controller@getAnnouncement');
    Route::get('/adminPassword','App\Http\Controllers\Controller@getAdminPassword');
    Route::get('/time','App\Http\Controllers\Controller@getTime');

    /**
     * Exports
     */
    Route::get('/export_excel/videos', [ExportVideosExcelController::class, 'index']);
    Route::get('/export_excel/excel/videos', [ExportVideosExcelController::class, 'excel'])->name('export_excel_videos.excel');
    Route::get('/export_excel/books', [ExportBooksExcelController::class, 'index']);
    Route::get('/export_excel/excel/books', [ExportBooksExcelController::class, 'excel'])->name('export_excel_books.excel');
    Route::get('/export_excel/devices', [ExportDevicesExcelController::class, 'index']);
    Route::get('/export_excel/excel/devices', [ExportDevicesExcelController::class, 'excel'])->name('export_excel_devices.excel');
});

