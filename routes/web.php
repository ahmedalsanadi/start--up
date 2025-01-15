<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageInvestor;
use App\Http\Controllers\Admin\ManageInvestorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RegistrationController; //investor
use App\Http\Controllers\Admin\DashboardController;


use App\Http\Controllers\Investor\CommercialRegistrationController;


use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;

use Illuminate\Support\Facades\Route;


// Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');
// Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
// Route::get('/jobs/{job}', [JobController::class, 'show'])->middleware('auth');
// Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->middleware(['auth', 'can:update,job']);
// Route::put('/jobs/{job}', [JobController::class, 'update'])->middleware(['auth', 'can:update,job']);
// Route::put('/jobs/{job}', [JobController::class, 'delete'])->middleware(['auth', 'can:delete,job']);



// Acessable Route
// Route::get('/', [JobController::class, 'index'])->name('jobs.index');
Route::get('/', function () {
    return redirect()->route('login'); // Assuming 'login' is the name of your login route
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'user_type:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.index');




    //list investors with their commercial registration number
    Route::get('/investors', [ManageInvestorController::class, 'index'])->name('admin.investors.index');

    Route::patch('/investors/{registration}', [ManageInvestorController::class, 'updateRegistrationStatus'])->name('admin.investor.updateStatus');


    // Route::patch('/registrations/{registration}', [RegistrationController::class, 'updateStatus'])->name('admin.registrations.update');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
});


// Commercial Registration Routes
Route::middleware(['auth', 'user_type:investor'])->group(function () {

    Route::get('/commercial-registration', [CommercialRegistrationController::class, 'create'])
        ->name('commercial-registration.create');


    Route::post('/commercial-registration', [CommercialRegistrationController::class, 'store'])
        ->name('commercial-registration.store');


    Route::get('/registration-pending', function () {
        return view('investor.pending.registration-pending');
    })->name('registration-pending');


});

// Protected Investor Routes
Route::middleware(['auth', 'user_type:investor', 'commercial.registration'])->group(function () {

    Route::get('/investor', function () {
        return view('investor');
    })->name('investor.dashboard');
    // Add other investor routes here


});

// Entrepreneur Routes
Route::middleware(['auth', 'user_type:entrepreneur'])->group(function () {
    Route::get('/entrepreneur', function () {
        return view('entrepreneur.index');
    })->name('entrepreneur.dashboard');
});


Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth')->name('logout');
