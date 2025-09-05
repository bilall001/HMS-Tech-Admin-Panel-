<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PointController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PointsController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\AddUserController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PasswordControler;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\TeamManagerController;
use App\Http\Controllers\Admin\ClientDashbordController;
use App\Http\Controllers\Admin\CompanyExpenseController;
use App\Http\Controllers\Admin\ProjectScheduleController;
use App\Http\Controllers\Admin\BusinessDeveloperController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\TeamManagerDashboardController;
use App\Http\Controllers\Admin\KhataAccountController;
use App\Http\Controllers\Admin\KhataEntryController;
use App\Http\Controllers\Admin\ImpersonationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login or dashboard
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login.form');
    }
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'business developer' => redirect()->route('business-developer.dashboard'),
        'client' => redirect()->route('client.dashboard'),
        'partner' => redirect()->route('admin.dashboard'),
        'team manager' => redirect()->route('teamManager.dashboard'),
        'developer' => redirect()->route('developer.dashboard'),
        default => redirect()->route('login.form'),
    };
});

// START impersonation: only admins can start
Route::middleware(['auth', 'can_impersonate'])->post('/admin/impersonate/{user}', [ImpersonationController::class, 'start'])
    ->name('impersonate.start');

// STOP impersonation: ANY logged-in session can stop (admin is currently impersonating a non-admin)
Route::middleware(['auth'])->post('/admin/impersonate/stop', [ImpersonationController::class, 'stop'])
    ->name('impersonate.stop');

// Everything below here requires authentication
Route::middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'TotalCLients'])->name('admin.index');

    // Passwords
    Route::resource('passwords', PasswordControler::class);

    // Add Users
    Route::resource('add-users', AddUserController::class)->except(['create']);

    // Developers
    Route::resource('developers', DeveloperController::class);
    // Leads
    Route::resource('leads', LeadController::class);
    // Route::post('/leads/show', [LeadController::class, 'show'])->name('leads.show');
    // Route::post('/leads/fields', [LeadController::class, 'fields'])->name('leads.fields');

    // Accounts
    Route::get('/khata/accounts',          [KhataAccountController::class, 'index'])->name('khata.accounts.index');
    Route::post('/khata/accounts',         [KhataAccountController::class, 'store'])->name('khata.accounts.store');
    Route::get('/khata/accounts/{id}/modal', [KhataAccountController::class, 'showModal'])
         ->name('khata.accounts.modal');
    Route::patch('/khata/accounts/{id}',   [KhataAccountController::class, 'update'])->name('khata.accounts.update');
    Route::delete('/khata/accounts/{id}',  [KhataAccountController::class, 'destroy'])->name('khata.accounts.destroy');

    // Entries
    Route::post('/khata/accounts/{khataAccountId}/entries', [KhataEntryController::class, 'store'])->name('khata.entries.store');
    Route::patch('/khata/entries/{entryId}',               [KhataEntryController::class, 'update'])->name('khata.entries.update');
    Route::delete('/khata/entries/{entryId}',              [KhataEntryController::class, 'destroy'])->name('khata.entries.destroy');
    // Clients
    Route::prefix('admin')->group(function () {
        Route::resource('clients', ClientController::class);
    });
    // Team-Manager
    Route::prefix('admin')->group(function () {
        Route::resource('team_managers', TeamManagerController::class)->except(['show', 'create', 'edit']);
    });

    // Company Expenses
    Route::resource('companyExpense', CompanyExpenseController::class);

    // Teams
    Route::resource('teams', TeamController::class);

    // Client Dashboard
    Route::get('/client/dashboard', [ClientDashbordController::class, 'dashboard'])
        ->middleware(['role:client'])
        ->name('client.dashboard');
    // developer dashboard
    Route::get('/developer/dashboard', [DeveloperController::class, 'index'])
        ->middleware(['role:developer'])
        ->name('developer.dashboard');
    // Team Managers Dashboard
    Route::get('/TeamManager/dashboard', [TeamManagerDashboardController::class, 'index'])
        ->middleware(['role:team manager'])
        ->name('teamManager.dashboard');

    // Attendance
    Route::prefix('admin')->name('attendances.')->group(function () {
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('index');
        Route::post('/attendances/store', [AttendanceController::class, 'store'])->name('store');
        Route::post('/attendances/mark-leave', [AttendanceController::class, 'markLeave'])->name('markLeave');
        Route::post('/attendances/mark-absent', [AttendanceController::class, 'markAbsent'])->name('markAbsent');
    });

    // Points for Developers
    Route::get('/developer/points', [PointsController::class, 'developerPoints'])->name('developer.points');
    Route::post('/developer/points', [PointsController::class, 'storeFromDeveloper'])->name('developer.points.store');
    Route::delete('/developer/points/{id}', [PointsController::class, 'destroy'])->name('developer.points.destroy');
    Route::get('/points/get-projects', [PointsController::class, 'getProjectsForDeveloper']);

    // Project Schedule
    Route::resource('projectSchedule', ProjectScheduleController::class);

    // Admin Teams
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('teams', TeamController::class)->except(['show']);
    });

    // Admin Projects
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('projects', ProjectController::class);
    });

    // Admin Dashboard (Stats) + Tasks
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'TotalCLients'])->name('admin.dashboard');

        Route::get('/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
        Route::post('/tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');

        Route::get('/project-files/{filename}', [TaskController::class, 'viewProjectFile'])
            ->name('projects.view_file');
    });

    // Extra task routes
    Route::get('/admin/teams/{id}/users', [TeamController::class, 'getUsers']);
    Route::get('/admin/tasks/project-info/{title}', [TaskController::class, 'getProjectInfo']);

    // Salaries
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('salaries', SalaryController::class);
    });

    // Partners
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('partners', PartnerController::class);
    });
});


Route::middleware(['auth'])->group(function () {
    Route::resource('business-developers', BusinessDeveloperController::class);
    Route::get('business-developer/dashboard', [BusinessDeveloperController::class, 'dashboard'])
        ->name('business-developer.dashboard');
});



Route::middleware(['auth', 'role:partner'])->group(function () {
    Route::get('/partner/dashboard', [PartnerController::class, 'dashboard'])->name('partner.dashboard');
});
