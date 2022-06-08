<?php

use App\Http\Controllers\Reply\ReplyController;
use App\Http\Controllers\SupportTicket\SupportTicketController;
use App\Http\Controllers\SupportTicket\SupportTicketReplyController;
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
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', [SupportTicketController::class, 'index'])->name('dashboard');
});

//Route::get('support-ticket/create', [SupportTicketController::class, 'create'])->name('create');

Route::controller(SupportTicketController::class)
    ->name('support-ticket.')
    ->prefix('support-tickets')
    ->group(function () {
        Route::middleware(['auth', 'can:supportAgent'])->group(function () {
            Route::get('/search', 'search')->name('search');
            Route::get('/', 'index')->name('index');
        });

        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/search-by-id/create', 'createSearchByRefId')->name('createSearchByRefId');
        Route::get('/search-by-id', 'searchByRefId')->name('searchByRefId');
        Route::get('/{supportTicket}', 'show')->name('show');
    });

Route::controller(SupportTicketReplyController::class)
    ->name('support-ticket.reply.')
    ->prefix('support-tickets')
    ->group(function () {
        Route::middleware(['auth', 'can:supportAgent'])->group(function () {
            Route::get('/{supportTicket}/replies/create', 'create')->name('create');
            Route::get('/{supportTicket}/replies', 'show')->name('show');
            Route::get('/{supportTicket}/assign-reply/create', 'createAssignReply')->name('assign.create');
            Route::get('/{id}/reply/create', 'create')->name('create');
            Route::post('/{supportTicket}/replies', 'store')->name('store');
            Route::post('/{supportTicket}/reply/assign', 'assign')->name('assign');
        });

        Route::get('/{supportTicket}/replies/{refId}', 'searchByRefId')->name('searchByRefId');
    });

Route::controller(ReplyController::class)
    ->name('support-ticket-replies.')
    ->prefix('support-ticket-replies')
    ->middleware(['auth', 'can:supportAgent'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search');
        Route::get('/{reply}', 'show')->name('show');

        Route::withoutMiddleware(['auth', 'can:supportAgent'])->get('/{replyId}/{referenceId}',
            'showByRefId')->name('showByRefId');

    });

//Route::resource('ticket.replies', SupportTicketController::class);


