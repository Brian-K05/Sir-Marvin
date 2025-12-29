<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ServiceController;
use App\Http\Controllers\Public\SubmissionController;
use App\Http\Controllers\Public\FeedbackController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\AdminPasswordController;
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

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// Submission routes - require authentication
Route::middleware('auth')->group(function () {
    Route::get('/my-bookings', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/create', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{id}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{id}/final-payment', [SubmissionController::class, 'uploadFinalPayment'])->name('submissions.upload-final');
    Route::get('/submissions/{id}/download', [SubmissionController::class, 'downloadCorrected'])->name('submissions.download');
    
    // Feedback routes
    Route::get('/submissions/{id}/feedback', [FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::post('/submissions/{id}/feedback', [FeedbackController::class, 'store'])->name('feedbacks.store');
    Route::get('/feedback/success', function () {
        return view('public.feedback.success');
    })->name('feedbacks.success');
});

// Admin Routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('submissions', AdminSubmissionController::class);
    Route::post('/submissions/{id}/status', [AdminSubmissionController::class, 'updateStatus'])->name('submissions.update-status');
    Route::post('/submissions/{id}/upload-corrected', [AdminSubmissionController::class, 'uploadCorrected'])->name('submissions.upload-corrected');
    
    Route::resource('payments', PaymentController::class)->only(['index', 'show']);
    Route::post('/payments/{id}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{id}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    
    Route::resource('services', AdminServiceController::class);
    
    // Feedback routes
    Route::get('/feedbacks', [AdminFeedbackController::class, 'index'])->name('feedbacks.index');
    Route::post('/feedbacks/{id}/approve', [AdminFeedbackController::class, 'approve'])->name('feedbacks.approve');
    Route::delete('/feedbacks/{id}', [AdminFeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    
    // Password change routes
    Route::get('/password/change', [AdminPasswordController::class, 'show'])->name('password.change');
    Route::put('/password/change', [AdminPasswordController::class, 'update'])->name('password.update');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/verify-password', [\App\Http\Controllers\ProfileController::class, 'verifyPassword'])->name('profile.verify-password');
    Route::post('/profile/update-email', [\App\Http\Controllers\ProfileController::class, 'updateEmail'])->name('profile.update-email');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
