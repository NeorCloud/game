<?php

use App\Domains\Backups\Http\Controllers\BackupController;
use App\Domains\Files\Http\Controllers\FileController;
use App\Domains\Games\Http\Controllers\GameController;
use App\Domains\Settings\Http\Controllers\SettingController;
use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });

//Settings
Route::group(['middleware' => 'check_setting_permission'], function () {
    Route::resource('settings', SettingController::class)->except(['create', 'store', 'destroy']);
    Route::get('/index2listSettings', [SettingController::class, 'index2list']);
});

//Files
Route::group(['middleware' => 'check_file_permission'], function () {
    Route::get('files/stream', [FileController::class, 'streamPrivateFile'])->name('files.stream');
    Route::resource('files', FileController::class);
    Route::delete('files/{deletedFile}/hardDelete', [FileController::class, 'hardDelete'])->name('files.hardDelete');
    Route::get('files/{deletedFile}/restore', [FileController::class, 'restore'])->name('files.restore');
    Route::get('index2listFiles', [FileController::class, 'index2list']);
});

//Databases
Route::group(['middleware' => 'check_backup_permission', 'prefix' => 'backups', 'as' => 'backups.'], function () {
    Route::get('', [BackupController::class, 'index'])->name('index');
    Route::get('/index2list', [BackupController::class, 'index2list'])->name('list');
    Route::get('/{backup}/download', [BackupController::class, 'download'])->name('download');
});

//todo add permissions
Route::group(['prefix' => 'games', 'as' => 'games.'], function () {
    Route::get('index2list', [GameController::class, 'index2list']);
    Route::get('', [GameController::class, 'index'])->name('index');
    Route::get('/index2list', [GameController::class, 'index2list'])->name('list');
    Route::get('/{game}', [GameController::class, 'show'])->name('show');
    Route::get('/{game}/leaderboard', [GameController::class, 'leaderboard'])->name('leaderboard');
});
