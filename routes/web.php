<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\RecruiterTeamMemberController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\MediaController;

Route::permanentRedirect('/home', '/');

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth
Route::get('/auth/{tab?}', [AuthController::class, 'show'])->name('auth');
Route::get('/login', function () {
    return redirect()->route('auth', ['tab' => 'login']);
})->name('login');
Route::get('/register', function () {
    return redirect()->route('auth', ['tab' => 'register']);
})->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Routes with auth needed
Route::middleware(['token.valid'])->group(function () {

    //Profile
    Route::get('/complete-profile', [ProfileController::class, 'showCompletionForm'])->name('complete-profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

    // Paramètres
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Candidatures
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

    // Pour le candidat
    Route::get('/my-applications', [ApplicationController::class, 'indexForCandidate'])->name('applications.candidate');

    // Pour le recruteur
    Route::get('/recruiter/applications', [ApplicationController::class, 'indexForRecruiter'])->name('applications.recruiter');
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    //Upload des medias
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('/media/delete/{id}', [MediaController::class, 'delete'])->name('media.delete');
});

// Accès public
Route::get('/job_offers', [JobOfferController::class, 'index'])->name('job_offers.index');
Route::get('/api/job_offers', [JobOfferController::class, 'api']);

// Accès aux fiches entreprises
Route::get('/companies', [RecruiterController::class, 'index'])->name('companies.index');
Route::get('/companies/{identifier}', [RecruiterController::class, 'show'])->name('companies.show');

// Pour recruteurs
Route::middleware(['token.valid', 'recruiter'])->group(function () {
    Route::get('/recruiter/my-job_offers', [JobOfferController::class, 'myOffers'])->name('recruiter.jobs.index');
    Route::get('/job_offers/create', [JobOfferController::class, 'create'])->name('recruiter.jobs.create');
    Route::post('/job_offers', [JobOfferController::class, 'store'])->name('recruiter.jobs.store');
    Route::get('/job_offers/{id}/edit', [JobOfferController::class, 'edit'])->name('recruiter.jobs.edit');
    Route::put('/job_offers/{id}', [JobOfferController::class, 'update'])->name('recruiter.jobs.update');
    Route::delete('/job_offers/{id}', [JobOfferController::class, 'destroy'])->name('recruiter.jobs.destroy');
    Route::put('/recruiter/{id}', [RecruiterController::class, 'update'])->name('recruiter.update');
    Route::post('/recruiter/{id}/team/sync', [RecruiterTeamMemberController::class, 'syncTeamMembers'])->name('recruiter.members.sync');
    Route::get('/cvtheque', [CandidateController::class, 'index'])->name('cvtheque.index');
});

Route::get('/job_offers/{id}', [JobOfferController::class, 'show'])->name('job_offers.show');
