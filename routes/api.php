<?php

use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\SupportTicketController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(SupportTicketController::class)
    ->prefix('api.support-tickets')
    ->name('api.support-tickets.')
    ->group(function () {
        Route::get('/search-by-id', 'searchByRefId')->name('searchByRefId');
    });

/*Route::controller(ReplyController::class)
    ->name('api.support-ticket-reply.')
    ->prefix('support-ticket-reply')
    ->group(function () {
        Route::get('/{reply}', 'show')->name('show');
    });*/