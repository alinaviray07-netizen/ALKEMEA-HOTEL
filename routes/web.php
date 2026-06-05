<?php
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoomImportController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [RoomController::class, 'index'])->name('home');
Route::get('/rooms/type/{roomType}', [RoomController::class, 'showByType'])->name('rooms.type.show');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('reservations.index');
})->middleware(['auth'])->name('dashboard');

/*Guest Routes*/

Route::middleware(['auth'])->group(function () {
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');

    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');

    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');

    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    /*Breeze Profile Routes */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Admin Room Management
        |--------------------------------------------------------------------------
        */

        Route::get('/rooms', [RoomController::class, 'adminIndex'])
            ->name('rooms.index');

        Route::get('/rooms/create', [RoomController::class, 'create'])
            ->name('rooms.create');

        Route::post('/rooms', [RoomController::class, 'store'])
            ->name('rooms.store');

        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])
            ->name('rooms.edit');

        Route::patch('/rooms/{room}', [RoomController::class, 'update'])
            ->name('rooms.update');

        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])
            ->name('rooms.destroy');

        /*
        |--------------------------------------------------------------------------
        | Admin Reservation Management
        |--------------------------------------------------------------------------
        */

        Route::get('/reservations', [ReservationController::class, 'adminIndex'])
            ->name('reservations.index');

        Route::patch('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])
            ->name('reservations.approve');

        Route::patch('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])
            ->name('reservations.reject');

        /*
        |--------------------------------------------------------------------------
        | Admin Payment Management
        |--------------------------------------------------------------------------
        */

        Route::get('/payments', [PaymentController::class, 'index'])
            ->name('payments.index');

        Route::get('/payments/{payment}', [PaymentController::class, 'show'])
            ->name('payments.show');

        Route::patch('/payments/{payment}', [PaymentController::class, 'update'])
            ->name('payments.update');

        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])
            ->name('payments.destroy');

        /*
        |--------------------------------------------------------------------------
        | Admin Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/reports/export/{type}/{format}', [ReportController::class, 'export'])
    ->name('reports.export');

Route::get('/rooms/import', [RoomImportController::class, 'create'])
    ->name('rooms.import.form');

Route::post('/rooms/import', [RoomImportController::class, 'store'])
    ->name('rooms.import');
    });

require __DIR__.'/auth.php';