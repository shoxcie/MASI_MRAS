<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginSubmit');

    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('registerSubmit');

    Route::get('/login/discord', [AuthController::class, 'discord'])->name('login.discord');
    Route::get('/login/discord/back', [AuthController::class, 'discordBack'])->name('login.discord.back');
});

Route::middleware('auth')->group(function () {
    Route::get('', fn () => to_route('projects.index'));
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('projects', ProjectsController::class);
    Route::resource('projects.reports', ReportController::class)->shallow();
    Route::get('reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');

    Route::get('projects/{project}/questions/{question}',
        [ProjectsController::class, 'question'])->name('projects.questions.show');

    Route::post('projects/{project}/questions/{question}',
        [ProjectsController::class, 'answer'])->name('projects.questions.answer');

    Route::get('docs/{page?}', [DocsController::class, 'docs'])->name('docs');
});
