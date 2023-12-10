<?php

use App\Http\Controllers\backend\AnnouncementController;
use App\Http\Controllers\backend\StripeController;
use App\Http\Controllers\backend\WalletController;
use App\Http\Controllers\TripController;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('layouts.header');
// });

Route::get('/', function () {
    return view('index');
});

Route::get('/testing', function () {
    return view('testing');
});

Route::get('/testing2', function () {
    return view('testing2');
});

Route::get('/googlemap', function () {
    return view('googlemap');
});

Auth::routes();
Route::get('/auth/settings/reset-password',  [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForms'])->name('auth.settings.reset-password')->middleware('auth');;
Route::post('/auth/settings/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'resets'])->name('auth.settings.reset')->middleware('auth');;
Route::get('/auth/settings/account', [App\Http\Controllers\Backend\UsersController::class, 'account'])->name('auth.settings.account')->middleware('auth');;

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// Data Tables
Route::get('/datatables', function () {
    return view('backend.datatables');
});

Route::get('/navbar', [App\Http\Controllers\backend\NotificationController::class, 'renderNavbar'])->name('navbar.render');

Route::get('/notifications', [App\Http\Controllers\backend\NotificationController::class, 'index'])->name('notifications.index');
Route::put('/notifications/{id}/mark-as-read', [App\Http\Controllers\backend\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::delete('/notifications/{id}', [App\Http\Controllers\backend\NotificationController::class, 'delete'])->name('notifications.delete');

// User Management
Route::get('/all-users', [App\Http\Controllers\backend\UsersController::class, 'AllUsers'])->name('all-users')->middleware('auth');
Route::get('/add-users', [App\Http\Controllers\backend\UsersController::class, 'AddUsers'])->name('add-users')->middleware('auth');
Route::post('/insert-users', [App\Http\Controllers\backend\UsersController::class, 'InsertUsers'])->name('insert-users')->middleware('auth');
Route::get('/edit-users/{id}', [App\Http\Controllers\backend\UsersController::class, 'EditUsers'])->name('edit-users')->middleware('auth');
Route::post('/update-users/{id}', [App\Http\Controllers\backend\UsersController::class, 'UpdateUsers'])->name('update-users')->middleware('auth');
Route::get('/delete-users/{id}', [App\Http\Controllers\backend\UsersController::class, 'DeleteUsers'])->name('delete-users')->middleware('auth');
Route::get('/my-profile', [App\Http\Controllers\backend\UsersController::class, 'myProfile'])->name('my-profile')->middleware('auth');
Route::get('/user-profile/{user_id}', [App\Http\Controllers\backend\UsersController::class, 'userProfile'])->name('user-profile')->middleware('auth');
Route::post('/my-profile/upload/image', [App\Http\Controllers\backend\UsersController::class, 'uploadImage'])->name('upload.image');
Route::post('/my-profile/updateSocialMedia', [App\Http\Controllers\backend\UsersController::class, 'uploadSocialMedia'])->name('my-profile.updateSocialMedia');
Route::post('/my-profile/updatePersonalDetails', [App\Http\Controllers\backend\UsersController::class, 'updatePersonalDetails'])->name('my-profile.updatePersonalDetails');

// example
// Route::resource('photos', PhotoController::class)->except(['index', 'show','create', 'store', 'update', 'destroy']);
// Route::resource('photos', PhotoController::class)->names(['create' => 'photos.build']); 
// Route::resource('users', AdminUserController::class)->parameters(['users' => 'admin_user']);

Route::get('/trips/test', function () {
    return view('trips.test');
});
Route::get('/trips/search', [App\Http\Controllers\backend\TripController::class, 'search'])->name('trips.search')->middleware('auth');
Route::post('/trips/{trip}/join', [App\Http\Controllers\backend\TripController::class, 'joinTrip'])->name('trips.joinTrip')->middleware('auth');
Route::post('/trips/{trip}/request', [App\Http\Controllers\backend\TripController::class, 'requestTrip'])->name('trips.requestTrip')->middleware('auth');
Route::post('/trips/searchResults', [App\Http\Controllers\backend\TripController::class, 'searchResults'])->name('trips.searchResults')->middleware('auth');
Route::get('/trips/myTrips', [App\Http\Controllers\backend\TripController::class, 'myTrips'])->name('trips.myTrips')->middleware('auth');
Route::get('/trips/{id}/join-requests', [\App\Http\Controllers\backend\TripController::class, 'showPendingJoinRequests'])
    ->name('trips.pendingJoinRequests')
    ->middleware('auth')
    ->where(['id' => '[0-9]+']);
// ->middleware(['auth', 'driver'])
Route::put('/trip_requests/{request}', [\App\Http\Controllers\backend\TripController::class, 'updateTripRequest'])->name('trip_requests.update');

Route::resource('trips', App\Http\Controllers\backend\TripController::class)->middleware('auth');


// Route::get('/chat', [\App\Http\Controllers\backend\ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{user_id}', [\App\Http\Controllers\backend\ChatController::class, 'chat'])->name('chat.chat')->middleware('auth');
Route::get('/chat/{user_id}/messages_chat', [\App\Http\Controllers\backend\ChatController::class, 'messagesChat'])->name('chat.messages_chat')->middleware('auth');
Route::get('/chat/{user_id}/userChat', [\App\Http\Controllers\backend\ChatController::class, 'userChat'])->name('chat.userChat')->middleware('auth');
Route::post('/chat/send', [\App\Http\Controllers\backend\ChatController::class, 'send'])->name('chat.send');

Route::middleware('auth')->group(function () {
    Route::resource('tripRequest', App\Http\Controllers\backend\TripRequestController::class);
    Route::post('/vehicles/images/upload', [App\Http\Controllers\backend\VehicleController::class, 'uploadImage'])->name('vehicles.uploadImage');
    Route::post('/vehicles/images/delete', [App\Http\Controllers\backend\VehicleController::class, 'deleteImage'])->name('vehicles.deleteImage');
    Route::post('/vehicles/images/update', [App\Http\Controllers\backend\VehicleController::class, 'updateImage'])->name('vehicles.updateImage');
    Route::get('/vehicles/list', [App\Http\Controllers\backend\VehicleController::class, 'list'])->name('vehicles.list');
    Route::post('/vehicles/update_vehicle/{id}', [App\Http\Controllers\backend\VehicleController::class, 'update_vehicle'])->name('vehicles.update_vehicle');
    Route::middleware('auth')->group(function () {
        Route::resource('vehicles', App\Http\Controllers\backend\VehicleController::class);
    });
});




Route::get('image/upload', [App\Http\Controllers\backend\VehicleController::class, 'upload']);
Route::post('image/upload/store', [App\Http\Controllers\backend\VehicleController::class, 'fileStore'])->name('image.upload.store');


//Route for submitting the form data
Route::post('/storedata', [App\Http\Controllers\backend\VehicleController::class, 'storeData'])->name('form.data');
//Route for submitting dropzone data
Route::post('/storeimage', [App\Http\Controllers\backend\VehicleController::class, 'storeImage']);

Route::middleware('auth')->group(
    function () {
        Route::get('/wallet/top-up', [StripeController::class, 'showTopUpForm'])->name('stripe.top-up');
        Route::post('/wallet/top-up', [StripeController::class, 'handleTopUp'])->name('stripe.top-up.submit');
        Route::get('/wallet/top-up/success', [StripeController::class, 'handleTopUpSuccess'])->name('stripe.top-up.success');
        Route::get('/wallet/top-up/cancel', [StripeController::class, 'handleTopUpCancel'])->name('stripe.top-up.cancel');
        Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook']);

        Route::get('/wallet/withdraw', [StripeController::class, 'withdraw'])->name('stripe.withdraw');
        Route::post('/wallet/withdraw', [StripeController::class, 'handleWithdrawal'])->name('stripe.withdraw.submit');

        Route::get('/wallet', [WalletController::class, 'showWallet'])->name('wallet.show');
        Route::get('/wallet/transfer', [WalletController::class, 'transfer'])->name('wallet.transfer');
        Route::post('/wallet/transfer', [WalletController::class, 'handleTransfer'])->name('wallet.transfer.submit');

        Route::get('/wallet/withdrawalRequest', [WalletController::class, 'withdrawalRequest'])->name('wallet.withdrawalRequest');
        ROute::post('/wallet/withdrawalRequest/approve/{id}', [WalletController::class, 'approveWithdrawalRequest'])->name('wallet.withdrawalRequest.approve');
        ROute::post('/wallet/withdrawalRequest/reject/{id}', [WalletController::class, 'rejectWithdrawalRequest'])->name('wallet.withdrawalRequest.reject');

        Route::post('/announcements/storedata', [AnnouncementController::class, 'storeData'])->name('announcements.storeData');
        Route::post('/announcements/image/upload', [AnnouncementController::class, 'storeImage']);
        Route::post('/announcements/image/updateImage', [AnnouncementController::class, 'updateImage'])->name('announcements.edit.updateImage');
        Route::post('/announcements/updateData/{id}', [AnnouncementController::class, 'updateData'])->name('announcements.updateData');
        Route::post('/announcements/image/deleteImage', [AnnouncementController::class, 'deleteImage'])->name('announcements.deleteImage');
        Route::resource('/announcements', AnnouncementController::class);
    }
);
