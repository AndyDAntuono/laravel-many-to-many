<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\TechnologyController;
// test di controllo della relazione tra il modello Technology e Project
use App\Models\Project;

/*
|-------------------------------------------------------------------------- 
| Web Routes
|-------------------------------------------------------------------------- 
| Here is where you can register web routes for your application. 
| These routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "web" middleware group. Make something great! 
| 
*/

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

Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function() {
    Route::resource('projects', ProjectController::class);
    Route::resource('types', TypeController::class);
    Route::resource('technologies', TechnologyController::class);
});

// test di controllo della relazione tra il modello Technology e Project
Route::get('/test-many-to-many', function() {
    // Recupera un progetto specifico con le tecnologie associate
    $project = Project::with('technologies')->find(1); // ID del progetto che vuoi testare

    // Mostra le tecnologie associate
    return $project->technologies;
});



// Rimuovi questa parte di codice, non è necessaria
// Route::middleware(['auth'])->group(function () {
//     // Rotte accessibili solo dopo l'autenticazione
// });

require __DIR__.'/auth.php';
