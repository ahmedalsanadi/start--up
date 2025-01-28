<?php
use App\Http\Controllers\Investor\InvestorHomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

// use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\{
    DashboardController,
    AdminCommericalRegistrationController,
    UserController,
    CategoriesController,
    AdminAnnouncementController,
    ExportController,
    IdeaController as AdminIdeaController
};

use App\Http\Controllers\Investor\{
    CommercialRegistrationController,
    AnnouncementController as InvestorAnnouncementController,
    IdeaController as InvestorIdeaController,
};

use App\Http\Controllers\Entrepreneur\{

    IdeaController as EntrepreneurIdeaController,
    EntrepreneurHomeController,
    AnnouncementController as EntrepreneurAnnouncementController
};

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;

// Acessable Route
// Route::get('/', [JobController::class, 'index'])->name('jobs.index');
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.home');
        } elseif ($user->isInvestor()) {
            $commercialRegistration = $user->commercialRegistration;

            if (!$commercialRegistration) {
                return redirect()->route('commercial-registration.create');
            } elseif ($commercialRegistration->status == 'pending') {
                return redirect()->route('pending-commercial-registration');
            } elseif ($commercialRegistration->status == 'approved') {
                return redirect()->route('investor.home');
            } else {
                return redirect()->route('commercial-registration.create');
            }
        } elseif ($user->isEntrepreneur()) {
            return redirect()->route('entrepreneur.home');
        }
    }

    return redirect()->route('login');
});


// Auth Routes ---------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

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
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('admin.users.toggle-active');

    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');

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
        ->name('admin.announcements.update-status'); // Update announcement approval status

    Route::get('/ideas', [AdminIdeaController::class, 'index'])->name('admin.ideas.index');

    Route::get('/ideas/{idea}', [AdminIdeaController::class, 'show'])->name('admin.ideas.show');

    Route::patch('/ideas/{idea}', [AdminIdeaController::class, 'updateStatus'])
        ->name('admin.ideas.update-status'); // Update idea approval status






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

        // New route for rejecting an idea
        Route::patch('/ideas/{idea}/reject', [InvestorIdeaController::class, 'rejectIdea'])
            ->name('investor.ideas.reject-idea');
        Route::patch('/ideas/{idea}/approve', [InvestorIdeaController::class, 'approveIdea'])
            ->name('investor.ideas.approve-idea');

    });


});




// Entrepreneur Routes
Route::prefix('entrepreneur')->middleware(['auth', 'user_type:entrepreneur'])->group(function () {

    Route::get('/', [EntrepreneurHomeController::class, 'index'])->name('entrepreneur.home');

    Route::resource('announcement', EntrepreneurAnnouncementController::class)->names([
        'show' => 'entrepreneur.announcements.show',
    ]);

    Route::resource('ideas', EntrepreneurIdeaController::class)->names([

        'index' => 'entrepreneur.ideas.index',
        'create' => 'entrepreneur.ideas.create',
        'store' => 'entrepreneur.ideas.store',
        'show' => 'entrepreneur.ideas.show',
        'edit' => 'entrepreneur.ideas.edit',
        'update' => 'entrepreneur.ideas.update',
        'destroy' => 'entrepreneur.ideas.destroy',
    ]);

});


Route::middleware('auth')->group(function () {


    Route::resource('profile', ProfileController::class)->only(['show', 'edit', 'update']);


    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
    //notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');

});


// Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->middleware('auth')->name('notifications.markAsRead');

//routes/web.php
Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index')
    ->middleware('auth');

// Mark all notifications as read
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])
    ->name('notifications.mark-as-read');

// Mark a single notification as read
Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.mark-as-read-single');

// Fetch unread notifications count
Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
    ->name('notifications.unread-count')
    ->middleware('auth');

