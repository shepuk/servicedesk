<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketBoardsController;
use App\Http\Controllers\TicketOrdersController;
use App\Http\Controllers\TicketColumnsController;
use App\Http\Controllers\TicketColumnsOrdersController;

use App\Http\Controllers\AssetsController;

use App\Http\Controllers\CompaniesController;

use App\Http\Controllers\PeopleController;

use App\Http\Controllers\AlertsController;

use App\Http\Controllers\LibraryController;

use App\Http\Controllers\SettingsController;

use App\Http\Controllers\MembershipController;

use App\Http\Controllers\SupportController;

use App\Http\Controllers\RoadmapController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
    Route::resource('user', UserController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('ticketboards', TicketBoardsController::class);
    Route::resource('ticketcolumns', TicketColumnsController::class);
    Route::resource('tickets', TicketsController::class);
    Route::resource('ticketorders', TicketOrdersController::class);
    Route::resource('ticketcolumnsorders', TicketColumnsOrdersController::class);

    Route::resource('assets', AssetsController::class);

    Route::resource('companies', CompaniesController::class);

    Route::resource('people', PeopleController::class);

    Route::resource('alerts', AlertsController::class);

    Route::resource('library', LibraryController::class);

    Route::resource('settings', SettingsController::class);

    Route::resource('membership', MembershipController::class);

    Route::resource('support', SupportController::class);

    Route::resource('roadmap', RoadmapController::class);
});



// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');
