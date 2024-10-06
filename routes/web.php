<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\roleChecker;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/voting');
})->name('welcome')->middleware(['auth']);

Route::prefix("voting")->as('voting.')->middleware(['auth'])->group(function () {

    Route::get('/',[ VotingController::class, 'index'])->name('index');
    Route::get('/list',[ VotingController::class, 'list'])->name('list');
    Route::get('/create',[ VotingController::class, 'create'])->name('create');
    Route::post('/store',[ VotingController::class, 'store'])->name('store');
    Route::get('/edit/{voting}',[ VotingController::class, 'edit'])->name('edit');
    Route::post('/update/{prevVoting}',[ VotingController::class, 'update'])->name('update');
    Route::get('/delete/{voting}',[ VotingController::class, 'delete'])->name('delete');
    Route::get('/candidates/{voting}',[ VotingController::class, 'candidates'])->name('candidates');

});

Route::prefix("candidate")->as('candidate.')->middleware(['auth'])->group(function () {

    Route::get('/add/{voting}',[ CandidateController::class, 'add'])->name('add');
    Route::post('/store/{voting}',[ CandidateController::class, 'store'])->name('store');
    Route::get('/edit/{candidate}',[ CandidateController::class, 'edit'])->name('edit');
    Route::post('/update/{prevCandidate}',[ CandidateController::class, 'update'])->name('update');
    Route::get('/delete/{candidate}',[ CandidateController::class, 'delete'])->name('delete');

});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
