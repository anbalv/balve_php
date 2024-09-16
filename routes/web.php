<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDbController;
use App\Http\Controllers\AddEventController;
use App\Http\Controllers\TasksCreateController;
use App\Http\Controllers\WkaKalenderController;
use App\Http\Controllers\TimezoneController;
use App\Http\Controllers\PointsCalController;
use App\Http\Controllers\RewardsController;
use App\Http\Controllers\AdminRewardsController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TestLogController;
use Illuminate\Support\Facades\Log;
use App\Jobs\ExampleJob;
use App\Http\Controllers\ScreenshotController;

// Hauptseite (Index)
Route::get('/', [MainController::class, 'index'])->name('main.index');

// Authentifizierung
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
    Route::get('/change_password', [AuthController::class, 'showChangePasswordForm'])->middleware('auth')->name('auth.change_password');
    Route::post('/change_password', [AuthController::class, 'changePassword'])->middleware('auth')->name('auth.change_password.post');
});

// Admin-Dashboard (nur für Admins)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin_dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/set_temp_password/{user_id}', [AdminController::class, 'setTempPassword'])->name('admin.set_temp_password');
    Route::post('/change_role', [AdminController::class, 'changeRole'])->name('admin.change_role');
    Route::post('/archive_tasks', [AdminController::class, 'archiveTasks'])->name('admin.archive_tasks');
});

// Benutzer-Dashboard (für authentifizierte Benutzer)
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserDbController::class, 'index'])->name('user.dashboard');
});

// Events erstellen
Route::group(['prefix' => 'add_event', 'middleware' => 'auth'], function () {
    Route::get('/', [AddEventController::class, 'index'])->name('event.index');
    Route::post('/', [AddEventController::class, 'store'])->name('event.store');
});

// Aufgabenverwaltung
Route::group(['prefix' => 'tasks_create', 'middleware' => 'auth'], function () {
    Route::get('/', [TasksCreateController::class, 'index'])->name('tasks.index');
    Route::post('/', [TasksCreateController::class, 'store'])->name('tasks.store');
});

// Benutzerdatenbank
Route::group(['prefix' => 'user_db', 'middleware' => 'auth'], function () {
    Route::get('/', [UserDbController::class, 'index'])->name('user_db.index');
});

// Kalenderansicht und Zeitzonen
Route::group(['prefix' => 'wka_kalender'], function () {
    Route::get('/', [WkaKalenderController::class, 'index'])->name('kalender.index');
});

Route::group(['prefix' => 'timezone'], function () {
    Route::get('/', [TimezoneController::class, 'index'])->name('timezone.index');
});

// Punkte und Belohnungen
Route::group(['prefix' => 'points_cal'], function () {
    Route::get('/', [PointsCalController::class, 'index'])->name('points.index');
});

Route::group(['prefix' => 'rewards'], function () {
    Route::get('/', [RewardsController::class, 'index'])->name('rewards.index');
});

Route::group(['prefix' => 'admin_rewards', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [AdminRewardsController::class, 'index'])->name('admin_rewards.index');
});

// E-Mail-Verwaltung
Route::group(['prefix' => 'email'], function () {
    Route::get('/', [EmailsController::class, 'index'])->name('email.index');
});

Route::get('/test-log', function () {
    Log::channel('daily')->info('This is a test log entry for the daily channel');
    Log::channel('single')->info('This is a test log entry for the single channel');
    Log::channel('critical')->critical('This is a critical test log entry');
    Log::channel('testlog')->info('This is a test log entry for the custom testlog channel');

    return 'Log entries have been created.';
});

Route::get('/create-test-log', [TestLogController::class, 'createTestLog']);

Route::get('/logs/{channel?}', [LogController::class, 'showLogs'])->name('logs.show');
Route::get('/logs/{channel?}', [LogController::class, 'showLogs'])->name('logs.show');
Route::post('/screenshot/save', [ScreenshotController::class, 'save'])->name('screenshot.save');

Route::get('/dispatch-job', function () {
    // Starte den Job mit Beispieldaten
    ExampleJob::dispatch('Test Data');

    return 'Job has been dispatched!';
});
