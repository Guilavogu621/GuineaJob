<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecrutementController;
use App\Http\Controllers\JobBoardController;
use App\Http\Controllers\AppelOffreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $dernieresOffres = \App\Models\OffreEmploi::with('entreprise')->latest()->take(3)->get();
    $derniersAppels = \App\Models\AppelOffre::with('entreprise')->latest()->take(3)->get();

    return view('welcome', compact('dernieresOffres', 'derniersAppels'));
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    // Redirection intelligente vers le bon espace selon le rôle
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->hasRole('employeur')) {
        return redirect()->route('employer.dashboard');
    }
    if ($user->hasRole('employe')) {
        return redirect()->route('employee.dashboard');
    }

    // Espace Candidat / Prestataire (dashboard générique)
    $candidatures = $user->hasRole('candidat')
        ? $user->candidatures()->with('offreEmploi.entreprise')->latest()->get()
        : collect();

    return view('dashboard', compact('candidatures'));
})->middleware(['auth'])->name('dashboard');

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

    // Gestion Globale des Contrats
    Route::get('/contracts', [\App\Http\Controllers\AdminController::class, 'listContracts'])->name('contracts.index');

    // Statistiques
    Route::get('/statistics', [\App\Http\Controllers\AdminController::class, 'statistics'])->name('statistics');
});

// Route changement de mot de passe obligatoire
Route::middleware('auth')->group(function () {
    Route::get('/password/change', [\App\Http\Controllers\EmployerController::class, 'showChangePassword'])->name('password.change');
    Route::post('/password/change', [\App\Http\Controllers\EmployerController::class, 'updatePassword'])->name('password.force.update');
});

// Routes Employeur
Route::middleware(['auth', 'password.change', 'role:employeur'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\EmployerController::class, 'dashboard'])->name('dashboard');

    // Gestion des employés par l'employeur
    Route::get('/employees', [\App\Http\Controllers\EmployerController::class, 'indexEmployees'])->name('employees.index');
    Route::get('/employees/create', [\App\Http\Controllers\EmployerController::class, 'createEmployee'])->name('employees.create');
    Route::post('/employees/store', [\App\Http\Controllers\EmployerController::class, 'storeEmployee'])->name('employees.store');
    Route::get('/employees/{employe}/edit', [\App\Http\Controllers\EmployerController::class, 'editEmployee'])->name('employees.edit');
    Route::post('/employees/{employe}/update', [\App\Http\Controllers\EmployerController::class, 'updateEmployee'])->name('employees.update');

    // Gestion des contrats (GUIN-2)
    Route::get('/contracts', [\App\Http\Controllers\EmployerController::class, 'indexContracts'])->name('contracts.index');
    Route::get('/contracts/create', [\App\Http\Controllers\EmployerController::class, 'createContract'])->name('contracts.create');
    Route::post('/contracts/store', [\App\Http\Controllers\EmployerController::class, 'storeContract'])->name('contracts.store');
    Route::get('/contracts/{contract}/edit', [\App\Http\Controllers\EmployerController::class, 'editContract'])->name('contracts.edit');
    Route::post('/contracts/{contract}/update', [\App\Http\Controllers\EmployerController::class, 'updateContract'])->name('contracts.update');
    Route::get('/contracts/{contract}/terminate', [\App\Http\Controllers\EmployerController::class, 'showTerminate'])->name('contracts.terminate');
    Route::post('/contracts/{contract}/terminate', [\App\Http\Controllers\EmployerController::class, 'processTerminate'])->name('contracts.process-terminate');

    // Workflow Signature Employeur
    Route::post('/contracts/{contract}/send', [\App\Http\Controllers\EmployerController::class, 'sendContract'])->name('contracts.send');
    Route::get('/contracts/{contract}', [\App\Http\Controllers\EmployerController::class, 'showContract'])->name('contracts.show');
    Route::post('/contracts/{contract}/sign', [\App\Http\Controllers\EmployerController::class, 'signContractEmployer'])->name('contracts.sign');
    Route::get('/contracts/{contract}/download', [\App\Http\Controllers\EmployerController::class, 'downloadPdf'])->name('contracts.download');

    // Gestion des congés (DS3)
    Route::get('/conges', [\App\Http\Controllers\CongeController::class, 'indexEmployer'])->name('conges.index');
    Route::post('/conges/{conge}/approve', [\App\Http\Controllers\CongeController::class, 'approveConge'])->name('conges.approve');
    Route::post('/conges/{conge}/reject', [\App\Http\Controllers\CongeController::class, 'rejectConge'])->name('conges.reject');

    // Gestion de la paie (DS4)
    Route::get('/paie', [\App\Http\Controllers\PaieController::class, 'indexEmployer'])->name('paie.index');
    Route::get('/paie/create', [\App\Http\Controllers\PaieController::class, 'createEmployer'])->name('paie.create');
    Route::post('/paie/store', [\App\Http\Controllers\PaieController::class, 'storeEmployer'])->name('paie.store');
    Route::get('/paie/{fichePaie}/download', [\App\Http\Controllers\PaieController::class, 'downloadPdf'])->name('paie.download');

    // --- Module Recrutement (DS5) ---
    Route::prefix('recrutement')->name('recrutement.')->group(function () {
        Route::get('/', [RecrutementController::class, 'index'])->name('index');
        Route::get('/create', [RecrutementController::class, 'create'])->name('create');
        Route::post('/', [RecrutementController::class, 'store'])->name('store');
        Route::get('/{offre}/applications', [RecrutementController::class, 'applications'])->name('applications');
        Route::patch('/applications/{candidature}', [RecrutementController::class, 'updateApplicationStatus'])->name('update-status');
        Route::delete('/{offre}', [RecrutementController::class, 'destroy'])->name('destroy');
    });

    // --- Module Appels d'Offres (B2B) ---
    Route::prefix('appels')->name('appels.')->group(function () {
        Route::get('/mes-appels', [AppelOffreController::class, 'mesAppels'])->name('index');
        Route::get('/create', [AppelOffreController::class, 'create'])->name('create');
        Route::post('/', [AppelOffreController::class, 'store'])->name('store');
        Route::get('/{appel}/propositions', [AppelOffreController::class, 'propositions'])->name('propositions');
    });
});

// Routes Employé
Route::middleware(['auth', 'password.change', 'role:employe'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/contract', [\App\Http\Controllers\EmployeeController::class, 'showContract'])->name('contract.show');

    // Workflow Signature Employé
    Route::post('/contract/{contract}/sign', [\App\Http\Controllers\EmployeeController::class, 'signContractEmployee'])->name('contract.sign');
    Route::get('/contract/{contract}/download', [\App\Http\Controllers\EmployeeController::class, 'downloadPdf'])->name('contract.download');

    // Gestion des congés (DS3)
    Route::get('/conges', [\App\Http\Controllers\CongeController::class, 'indexEmployee'])->name('conges.index');
    Route::get('/conges/create', [\App\Http\Controllers\CongeController::class, 'createEmployee'])->name('conges.create');
    Route::post('/conges/store', [\App\Http\Controllers\CongeController::class, 'storeEmployee'])->name('conges.store');

    // Mes bulletins de paie (DS4)
    Route::get('/paie', [\App\Http\Controllers\PaieController::class, 'indexEmployee'])->name('paie.index');
    Route::get('/paie/{fichePaie}/download', [\App\Http\Controllers\PaieController::class, 'downloadPdf'])->name('paie.download');
});

// --- Job Board Publique (DS5) ---
Route::get('/emplois', [JobBoardController::class, 'index'])->name('jobboard.index');
Route::get('/emplois/{offre}', [JobBoardController::class, 'show'])->name('jobboard.show');

// --- Postuler (Nécessite d'être connecté) ---
Route::middleware(['auth', 'role:candidat'])->group(function () {
    Route::get('/candidat/emplois', [\App\Http\Controllers\CandidateController::class, 'jobs'])->name('candidate.jobs.index');
    Route::get('/candidat/emplois/{offre}', [\App\Http\Controllers\CandidateController::class, 'show'])->name('candidate.jobs.show');
    Route::get('/candidat/emplois/{offre}/postuler', [\App\Http\Controllers\CandidateController::class, 'apply'])->name('candidate.jobs.apply');
    Route::post('/candidat/emplois/{offre}/postuler', [\App\Http\Controllers\CandidateController::class, 'storeApplication'])->name('candidate.jobs.store');
});

// --- Appels d'Offres Publics (B2B) ---
Route::get('/appels-offres', [AppelOffreController::class, 'index'])->name('appels.public.index');
Route::get('/appels-offres/{appel}', [AppelOffreController::class, 'show'])->name('appels.show');
Route::post('/appels-offres/{appel}/proposer', [AppelOffreController::class, 'submitProposal'])->name('appels.proposer')->middleware(['auth', 'role:prestataire']);

require __DIR__.'/auth.php';
