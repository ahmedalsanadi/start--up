<?php
use App\Http\Controllers\Investor\InvestorHomeController;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\{
    DashboardController,
    AdminCommericalRegistrationController,
    UserController,
    CategoriesController,
    AdminAnnouncementController,
    ExportController,
// IdeaController
};

use App\Http\Controllers\Investor\{
    CommercialRegistrationController,
    AnnouncementController as InvestorAnnouncementController,
    IdeaController as InvestorIdeaController,
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






// Auth Routes ---------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});



// Admin Routes ---------------------------------------------------------------------

Route::prefix('admin')->middleware(['auth', 'user_type:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.home');

    // List investors with their commercial registration number
    Route::get('/commercial-registrations', [AdminCommericalRegistrationController::class, 'index'])->name('admin.commerical-registrations.index');

    // Update Commercial registration status
    Route::patch('/commercial-registrations/{registration}', [AdminCommericalRegistrationController::class, 'updateRegistrationStatus'])->name('admin.commercial-registrations.updateStatus');

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

    // Admin Announcement Routes
    Route::get('/announcements', [AdminAnnouncementController::class, 'index'])
        ->name('admin.announcements.index'); // Display list of announcements

    Route::get('/announcements/{announcement}', [AdminAnnouncementController::class, 'show'])
        ->name('admin.announcements.show'); // Show a single announcement

    Route::patch('/announcements/{announcement}', [AdminAnnouncementController::class, 'updateStatus'])
        ->name('admin.announcements.update-status'); // Update announcement status

    Route::get('/ideas', function () {
        return "Manage Ideas";
    })->name('admin.ideas.index');


    //excel export route
    Route::post('export/{type}', [ExportController::class, 'export'])->name('export');

    //report route
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('admin.reports.index');

});


// Commercial Registration Routes -----------------------------------------------------------------------

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

// Protected Investor Routes -------------------------------------------------------
Route::middleware(['auth', 'user_type:investor', 'commercial.registration'])->group(function () {


    Route::prefix('/investor')->group(function () {

     // Investor Home (Display ideas with search/filter capabilities)

        Route::get('/', [InvestorHomeController::class, 'index'])->name('investor.home');

        // Investor Announcements
        Route::resource('announcement', InvestorAnnouncementController::class)->names([
            'index' => 'investor.announcements.index',
            'create' => 'investor.announcements.create',
            'store' => 'investor.announcements.store',
            'show' => 'investor.announcements.show',
            'edit' => 'investor.announcements.edit',
            'update' => 'investor.announcements.update',
            'destroy' => 'investor.announcements.destroy',
        ]);

        Route::patch('/announcement/{announcement}/toggle-closed', [InvestorAnnouncementController::class, 'toggleClosed'])
        ->name('investor.announcements.toggle-closed');

        Route::patch('/idea/{idea}', [InvestorAnnouncementController::class, 'updateStatus'])->name('investor.ideas.update-stage');

         // New route for showing idea details
         Route::get('/ideas/{idea}', [InvestorIdeaController::class, 'show'])
         ->name('investor.ideas.show');

    });


});




// Entrepreneur Routes
Route::prefix('entrepreneur')->middleware(['auth', 'user_type:entrepreneur'])->group(function () {
    Route::get('/', function () {
        return view('entrepreneur.index');
    })->name('entrepreneur.home');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return "user profile";

    })->name('user.profile');

    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
    //notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');
});


// Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->middleware('auth')->name('notifications.markAsRead');
