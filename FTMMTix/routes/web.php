<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    AuthController, HomeController, EventController, OrderController,
    PaymentController, TicketController, StudentController,
    Admin\AdminController, Admin\AdminAuthController, Admin\AdminEventController
};
use App\Models\Event;

// === ADMIN ROUTES ===
Route::resource('/admin/events', AdminEventController::class)->names('admin.events');

// === DUMMY EVENTS ===
$dummyEvents = [
    1 => [
        'id' => 1,
        'title' => 'GIZHA GAMING',
        'description' => 'Turnamen e-sports tahunan dengan hadiah menarik!',
        'image' => 'images/internship-duta-ftmm.jpg',
        'date' => '2025-10-15',
        'location' => 'Aula FTMM',
        'price' => 25000,
    ],
    2 => [
        'id' => 2,
        'title' => 'Synreach FTMM',
        'description' => 'Seminar teknologi dan inovasi di FTMM.',
        'image' => 'images/synreach-ftmm.jpg',
        'date' => '2025-11-05',
        'location' => 'Aula Kampus',
        'price' => 50000,
    ],
    3 => [
        'id' => 3,
        'title' => 'Nama Event 3',
        'description' => 'Deskripsi untuk event 3.',
        'image' => 'images/event-poster-sample.jpg',
        'date' => '2025-12-10',
        'location' => 'Aula FTMM',
        'price' => 30000,
    ],
    4 => [
        'id' => 4,
        'title' => 'Nama Event 4',
        'description' => 'Deskripsi untuk event 4.',
        'image' => 'images/event-poster-sample.jpg',
        'date' => '2026-01-20',
        'location' => 'Aula FTMM',
        'price' => 40000,
    ],
];

// === DUMMY EVENT LIST (preview semua dummy) ===
Route::get('/event/dummy', function () use ($dummyEvents) {
    return view('dummy-events', ['events' => $dummyEvents]);
})->name('dummy.list');

// === DUMMY EVENT DETAIL ===
Route::get('/event/dummy/{id}', function ($id) use ($dummyEvents) {
    $event = $dummyEvents[$id] ?? abort(404);
    return view('event-detail', compact('event'));
})->name('dummy.detail');

// === DUMMY EVENT ORDER ===
Route::get('/event/dummy/{id}/order', function ($id) use ($dummyEvents) {
    $event = $dummyEvents[$id] ?? abort(404);
    return view('order-ticket', compact('event'));
})->name('order.dummy');

// Handle POST order pada dummy event agar tidak 404
Route::post('/event/dummy/{id}/order', function ($id) {
    return redirect()->route('dummy.list')->with('error', 'Pemesanan hanya tersedia untuk event asli.');
});

// ORDER HISTORY
Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');


// === AUTH & HOME ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function() {
    return view('about');
})->name('about');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.do');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.do');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === ADMIN LOGIN ===
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.do');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// === EVENT (DATABASE) ===
Route::get('/event', [EventController::class, 'index'])->name('events.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');

Route::middleware(['auth:web,lecturer,user'])->group(function () {
    Route::get('/event/{id}/order', function ($id) {
        $event = Event::findOrFail($id);
        return view('order-ticket', compact('event'));
    })->name('order.create');

    Route::post('/order', [OrderController::class, 'storeOrder'])->name('order.store');
    
    // Payment routes
    Route::get('/payment/{order}', [PaymentController::class, 'showPayment'])->name('payment.show');
    Route::post('/payment/{order}/upload', [PaymentController::class, 'uploadProof'])->name('payment.upload');
    Route::get('/payment/{order}/eticket', [PaymentController::class, 'showEticket'])->name('payment.eticket');
});



// === PROTECTED (auth only) ===
Route::middleware('auth')->group(function () {
    Route::post('/events/{event:slug}/add', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.place');

    Route::prefix('orders/{order}/payment')->group(function () {
        Route::get('/', [PaymentController::class, 'showBanks'])->name('payments.showBanks');
        Route::post('/choose', [PaymentController::class, 'chooseBank'])->name('payments.chooseBank');
        Route::post('/confirm', [PaymentController::class, 'confirmTransfer'])->name('payments.confirmTransfer');
    });

    Route::get('/tickets/{order}', [TicketController::class, 'show'])->name('tickets.show');
});

// === ACCOUNT MANAGEMENT ===
    Route::middleware(['auth:web,lecturer,user'])->group(function () {
        Route::get('/account/edit', function() {
            if(auth('lecturer')->check()) {
                return app(\App\Http\Controllers\LecturerController::class)->editSelf();
            } elseif(auth('user')->check()) {
                return app(\App\Http\Controllers\UserController::class)->editSelf();
            } else {
                return app(\App\Http\Controllers\StudentController::class)->editSelf();
            }
        })->name('account.edit');
        Route::put('/account/update', function(Request $request) {
            if(auth('lecturer')->check()) {
                return app(\App\Http\Controllers\LecturerController::class)->updateSelf($request);
            } elseif(auth('user')->check()) {
                return app(\App\Http\Controllers\UserController::class)->updateSelf($request);
            } else {
                return app(\App\Http\Controllers\StudentController::class)->updateSelf($request);
            }
        })->name('account.update');
        Route::delete('/account/delete', function(Request $request) {
            if(auth('lecturer')->check()) {
                return app(\App\Http\Controllers\LecturerController::class)->destroySelf($request);
            } elseif(auth('user')->check()) {
                return app(\App\Http\Controllers\UserController::class)->destroySelf($request);
            } else {
                return app(\App\Http\Controllers\StudentController::class)->destroySelf($request);
            }
        })->name('account.delete');
    });
