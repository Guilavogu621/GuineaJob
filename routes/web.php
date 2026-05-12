<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    // Gestion des Utilisateurs (GUIN-1)
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'listUsers'])->name('users.index');
    Route::post('/users/{user}/role', [\App\Http\Controllers\AdminController::class, 'updateUserRole'])->name('users.update-role');

    Route::get('/create-employer', [\App\Http\Controllers\AdminController::class, 'create'])->name('create-employer');
    Route::post('/create-employer', [\App\Http\Controllers\AdminController::class, 'store'])->name('store-employer');
});

// Route changement de mot de passe obligatoire
Route::middleware('auth')->group(function () {
    Route::get('/password/change', [\App\Http\Controllers\EmployerController::class, 'showChangePassword'])->name('password.change');
    Route::post('/password/change', [\App\Http\Controllers\EmployerController::class, 'updatePassword'])->name('password.update');
});

// Routes Employeur
Route::middleware(['auth', 'password.change', 'role:employeur'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\EmployerController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des employés par l'employeur
    Route::get('/employees', [\App\Http\Controllers\EmployerController::class, 'indexEmployees'])->name('employees.index');
    Route::get('/employees/create', [\App\Http\Controllers\EmployerController::class, 'createEmployee'])->name('employees.create');
    Route::post('/employees/store', [\App\Http\Controllers\EmployerController::class, 'storeEmployee'])->name('employees.store');

    // Gestion des contrats (GUIN-2)
    Route::get('/contracts', [\App\Http\Controllers\EmployerController::class, 'indexContracts'])->name('contracts.index');
    Route::get('/contracts/create', [\App\Http\Controllers\EmployerController::class, 'createContract'])->name('contracts.create');
    Route::post('/contracts/store', [\App\Http\Controllers\EmployerController::class, 'storeContract'])->name('contracts.store');
    
    // Workflow Signature Employeur
    Route::post('/contracts/{contract}/send', [\App\Http\Controllers\EmployerController::class, 'sendContract'])->name('contracts.send');
    Route::post('/contracts/{contract}/sign', [\App\Http\Controllers\EmployerController::class, 'signContractEmployer'])->name('contracts.sign');
});

// Routes Employé
Route::middleware(['auth', 'password.change', 'role:employe'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/contract', [\App\Http\Controllers\EmployeeController::class, 'showContract'])->name('contract.show');
    
    // Workflow Signature Employé
    Route::post('/contract/{contract}/sign', [\App\Http\Controllers\EmployeeController::class, 'signContractEmployee'])->name('contract.sign');
});

require __DIR__.'/auth.php';
