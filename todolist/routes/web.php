<?php

use App\Http\Controllers\Authorization\RegistrationController;
use App\Http\Controllers\Authorization\LoginController;
use App\Http\Controllers\Task\TaskListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get(
        'registration',
        [RegistrationController::class, 'view']
    )->name('registration');
    
    Route::post(
        'registration',
        [RegistrationController::class, 'registration']
    )->name('registration-post');
    
    Route::get(
        'login',
        [LoginController::class, 'view']
    )->name('login');
    
    Route::post(
        'login',
        [LoginController::class, 'login']
    )->name('login-post');
});

Route::middleware('auth')->group(function () {
    Route::get(
        'logout',
        [LoginController::class, 'logout']
    )->name('logout');

    Route::get(
        'tasklists',
        [TaskListController::class, 'view']
    )->name('tasklists');

    Route::post(
        'tasklists',
        [TaskListController::class, 'create']
    )->name('tasklist-create');

    Route::post(
        'tasklists/{tasklist}/remove',
        [TaskListController::class, 'remove']
    )->name('tasklist-remove');

    Route::get(
        'tasklists/{tasklist}/tasks',
        [TaskListController::class, 'tasks']
    )->name('tasklist-tasks');

    Route::post(
        'tasklists/{tasklist}/tasks/new-task',
        [TaskListController::class, 'create_task']
    )->name('tasklist-new-task');

    Route::post(
        'tasklists/{tasklist}/tasks/{task}/remove',
        [TaskListController::class, 'remove_task']
    )->name('tasklist-remove-task');
});
