<?php
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\{
    DashboardController,
    ManageInvestorController,
    UserController,
    CategoriesController,
    AdminAnnouncementController
// IdeaController
};

use App\Http\Controllers\Investor\{
    CommercialRegistrationController,
    AnnouncementController as InvestorAnnouncementController
};


use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;




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
    Route::get('/', [DashboardController::class, 'index'])->name('admin.home');

    // List investors with their commercial registration number
    Route::get('/investors', [ManageInvestorController::class, 'index'])->name('admin.investors.index');

    // Update Commercial registration status
    Route::patch('/investors/{registration}', [ManageInvestorController::class, 'updateRegistrationStatus'])->name('admin.investor.updateStatus');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');

    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

    // Resource route for categories with name prefix
    Route::resource('categories', CategoriesController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('admin.announcements.index');

    Route::get('/announcements/{announcement}', [AdminAnnouncementController::class, 'show'])->name('admin.announcements.show');

    Route::patch('/announcements/{announcement}', [AdminAnnouncementController::class, 'updateStatus'])->name('admin.announcements.update-status');

});





// Commercial Registration Routes
Route::middleware(['auth', 'user_type:investor'])->group(function () {

    //allow investor to enter the commercial registration number
    Route::get('/commercial-registration', [CommercialRegistrationController::class, 'create'])
        ->name('commercial-registration.create');


    Route::post('/commercial-registration', [CommercialRegistrationController::class, 'store'])
        ->name('commercial-registration.store');

    //display pending page
    Route::get('/pending-commercial-registration', [CommercialRegistrationController::class, 'displayPendingPage'])->name('pending-commercial-registration');

    //check registration status and refresh the pending page by ajax
    Route::get('/check-registration-status', [CommercialRegistrationController::class, 'checkStatus'])
        ->name('check.registration.status');

});

// Protected Investor Routes
Route::middleware(['auth', 'user_type:investor', 'commercial.registration'])->group(function () {

    Route::get('/investor', function () {
        return view('investor.index');
    })->name('investor.home');
    // Add other investor routes here

    Route::get('/announcements', [InvestorAnnouncementController::class, 'index'])->name('investor.announcements.index');

});




// Entrepreneur Routes
Route::prefix('entrepreneur')->middleware(['auth', 'user_type:entrepreneur'])->group(function () {
    Route::get('/', function () {
        return view('entrepreneur.index');
    })->name('entrepreneur.home');
});


Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth')->name('logout');

// Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->middleware('auth')->name('notifications.markAsRead');
