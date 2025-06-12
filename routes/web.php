<?php

use App\Http\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Chat\CreateChat;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SeekerDashboardController;

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
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chat Routes
    Route::get('/users', CreateChat::class)->name('users');
    //Route::get('/chat/{user_id?}', Main::class)->name('chat');
    Route::get('/chat/{key?}', Main::class)->name('chat');

    // Dashboard
    Route::get('/seeker-dashboard', [SeekerDashboardController::class, 'index'])
        ->name('seeker-dashboard');

    // like dislike
    Route::post('/services/{service}/like', [ServiceController::class, 'like'])->name('services.like');
    Route::post('/services/{service}/unlike', [ServiceController::class, 'unlike'])->name('services.unlike');

    // Categories Routes
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/{category}/services', [CategoryController::class, 'showServices'])
        ->name('categories.services');

    Route::get('/categories/{category}', [CategoryController::class, 'showFilter'])
        ->name('categories.show');

    // Service Routes
    Route::resource('services', ServiceController::class);

    Route::get('/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])
        ->name('services.toggle-status');

    Route::post('/services/{service}/request-deal', [ServiceController::class, 'requestDeal'])
        ->name('services.requestDeal');
    
    Route::post('/services/{service}/accept-deal', [ServiceController::class, 'acceptDeal'])
        ->name('services.acceptDeal');
    
    Route::patch('/services/{service}/reject-request', [ServiceController::class, 'rejectRequest'])
        ->name('services.rejectRequest');

    Route::post('/services/{service}/confirm-trade', [ServiceController::class, 'confirmTrade'])
        ->name('services.confirmTrade');
        
    Route::patch('/services/{service}/cancel-request', [ServiceController::class, 'cancelRequest'])
        ->name('services.cancelRequest');
    
    Route::patch('/services/{service}/complete', [ServiceController::class, 'complete'])
        ->name('services.complete');

    // Form rating & review
    Route::get('services/{service}/review', [ReviewController::class, 'create'])
        ->name('services.review.create');

    // Submit rating & review
    Route::post('services/{service}/review', [ReviewController::class, 'store'])
        ->name('services.review.store');

    // Request
    Route::get('/my-requests', [ServiceController::class, 'myRequests'])->name('services.my-requests');
    Route::get('/requests/create', [ServiceController::class, 'createRequest'])->name('services.create-request');
    Route::post('/requests', [ServiceController::class, 'storeRequest'])->name('services.store-request');
    Route::delete('/requests/{service}', [ServiceController::class, 'cancelRequest'])->name('services.cancel-request');

    // About Us Page
    Route::get('/about-us', [PagesController::class, 'aboutUs'])->name('about-us');

    // Contact Us Page
    Route::get('/contact-us', [PagesController::class, 'contactUs'])->name('contact-us');

    // Contact Us Form Submission
    Route::post('/contact-us/submit', [PagesController::class, 'submitContactForm'])
        ->name('contact-us.submit');
});