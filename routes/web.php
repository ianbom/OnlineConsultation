<?php

use App\Http\Controllers\Admin\BookingController as AdmBookingController;
use App\Http\Controllers\Admin\ClientController as AdmClientController;
use App\Http\Controllers\Admin\CounselorController as AdmCounselorController;
use App\Http\Controllers\Admin\CounselorWorkDayController as AdmCounselorWorkDayController;
use App\Http\Controllers\Admin\DashboardController as AdmDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdmProfileController;
use App\Http\Controllers\Admin\RefundController as AdmRefundController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Client\CounselorController as ClientCounselorController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\PaymentController as ClientPaymentController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Client\RatingController as ClientRatingController;
use App\Http\Controllers\Counselor\BookingController as CounselorBookingController;
use App\Http\Controllers\Counselor\DashboardController as CounselorDashboardController;
use App\Http\Controllers\Counselor\ProfileController as CounselorProfileController;
use App\Http\Controllers\Counselor\WorkDayController as CounselorWorkDayController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dbs', function () {
    return view('dashboard');
});

Route::get('/tes/{bookingId}', function ($bookingId) {
    $booking = \App\Models\Booking::with('client', 'schedule', 'secondSchedule', 'previousSchedule',
        'previousSecondSchedule', 'payment', 'counselor.user', 'rating')->findOrFail($bookingId);
    return view('tes', ['booking' => $booking]);
})->name('tes');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdmDashboardController::class, 'index'])->name('dashboard');
    Route::resource('counselor', AdmCounselorController::class);
    Route::resource('workday', AdmCounselorWorkDayController::class);
    Route::get('booking/export', [AdmBookingController::class, 'export'])->name('booking.export');
    Route::put('booking/{bookingId}/mark-settled', [AdmBookingController::class, 'markSettled'])->name('booking.mark-settled');
    Route::resource('booking', AdmBookingController::class);
    Route::resource('refund', AdmRefundController::class);
    Route::put('refund-approve/{paymendId}',[ AdmRefundController::class, 'changeRefundStatus'])->name('payment.changeRefundStatus');
    Route::resource('client', AdmClientController::class);
    Route::get('/profile', [AdmProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [AdmProfileController::class, 'update'])->name('profile.update');
    
});

Route::middleware(['role:counselor,admin'])->prefix('counselor')->as('counselor.')->group(function () {
    Route::get('/dashboard', [CounselorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [CounselorProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [CounselorProfileController::class, 'update'])->name('profile.update');
    Route::get('/workday-schedule', [CounselorWorkDayController::class, 'index'])->name('workday.index');
    Route::get('/booking', [CounselorBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{bookingId}', [CounselorBookingController::class, 'show'])->name('booking.show');
    Route::put('/booking/change-reschedule-status/{bookingId}', [CounselorBookingController::class, 'changeStatusReschedule'])->name('change.reshceduleStatus');
    Route::put('/booking/input-link-notes/{bookingId}', [CounselorBookingController::class, 'inputLinkandNotes'])->name('booking.inputLinkandNotes');
    Route::put('/complete-booking/{bookingId}', [CounselorBookingController::class, 'completeBooking'])->name('booking.completeBooking');
});



Route::middleware(['auth', 'verified'])->prefix('client')->as('client.')->group(function () {
    Route::get('/list-counselors', [ClientCounselorController::class, 'counselorList'])->name('counselor.list');
    Route::get('/counselor/{counselorId}', [ClientCounselorController::class, 'detailCounselor'])->name('counselor.show');
    Route::get('/pick-counselor/schedule/{counselorId}', [ClientCounselorController::class, 'pickCounselorSchedule'])->name('pick.schedule');
    Route::get('/process-payment/{counselorId}/{scheduleIds}', [ClientCounselorController::class, 'processPayment'])->name('process.payment');
    Route::post('/book-schedule/{counselorId}', [ClientBookingController::class, 'bookingSchedule'])->name('book.schedule');
    Route::get('/booking-detail/{bookingId}', [ClientBookingController::class, 'bookingDetail'])->name('booking.detail');
    Route::get('/reschedule-booking/{bookingId}', [ClientBookingController::class, 'pickRescheduleBooking'])->name('pick.reschedule');
    Route::post('/update/reschedule-booking/{bookingId}', [ClientBookingController::class, 'rescheduleBooking'])->name('reschedule.booking');
    Route::post('/cancel-booking/{bookingId}', [ClientBookingController::class, 'cancelBooking'])->name('cancel.booking');
    Route::get('/check-payment/{booking}', [ClientPaymentController::class, 'checkPayment'])->name('payment.check');
    Route::get('/booking-history', [ClientBookingController::class, 'bookingHistory'])->name('booking.history');
    Route::get('/my-profile', [ClientProfileController::class, 'myProfile'])->name('myProfile');
    Route::post('/update-profile', [ClientProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/faq', [ClientDashboardController::class, 'faq'])->name('faq');
    Route::post('/rating', [ClientRatingController::class, 'store'])->name('rating.store');
    Route::put('/rating/{ratingId}', [ClientRatingController::class, 'update'])->name('rating.update');
});


Route::get('/dashboard', function () {
    return Inertia::render('DashboardClient');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
