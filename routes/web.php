<?php

use App\Http\Controllers\Admin\ClientDashbordController;
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
use App\Http\Controllers\Admin\PasswordControler;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\CompanyExpenseController;
use App\Http\Controllers\Admin\ProjectScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

// 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login or dashboard
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.index')
        : redirect()->route('login.form');
});

// Protected Admin Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index'); // 🟢 This must exist!
    })->name('admin.index');
        Route::get('/', [AdminController::class, 'TotalCLients'])->name('admin.index');

});


// 


 
    Route::resource('passwords', PasswordControler::class);
    Route::resource('add-users', AddUserController::class);
    Route::resource('developers', DeveloperController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('companyExpense', CompanyExpenseController::class);
    
Route::middleware(['auth'])->group(function() {
    Route::resource('teams', TeamController::class);
});

// web.php

Route::get('/client/dashboard', [ClientDashbordController::class, 'dashboard'])
    ->middleware(['auth', 'role:client'])
    ->name('client.dashboard');

    
 Route::prefix('admin')->name('attendances.')->group(function () {
  Route::get('/attendances', [AttendanceController::class, 'index'])->name('index');
  Route::post('/attendances/store', [AttendanceController::class, 'store'])->name('store');
  Route::post('/attendances/mark-leave', [AttendanceController::class, 'markLeave'])->name('markLeave');
  Route::post('/attendances/mark-absent', [AttendanceController::class, 'markAbsent'])->name('markAbsent'); // ✅ fixed
});

Route::middleware(['auth'])->group(function () {
    Route::get('/developer/points', [PointsController::class, 'developerPoints'])->name('developer.points');
    Route::post('/developer/points', [PointsController::class, 'storeFromDeveloper'])->name('developer.points.store');
    Route::delete('/developer/points/{id}', [PointsController::class, 'destroy'])->name('developer.points.destroy');
    Route::get('/points/get-projects', [PointsController::class, 'getProjectsForDeveloper']);
    
});


// 

Route::resource('projectSchedule', ProjectScheduleController::class);
//
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('teams', TeamController::class)->except(['show']);
});




Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('projects', ProjectController::class);
});






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

Route::get('/admin/teams/{id}/users', [TeamController::class, 'getUsers']);




Route::get('/admin/tasks/project-info/{title}', [TaskController::class, 'getProjectInfo']);


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('salaries', SalaryController::class);
});