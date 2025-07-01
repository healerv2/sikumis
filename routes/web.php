<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    UserController,
    SuplemenController,
    PostController,
    PasienController,
    NotificationSettingController,
    NotifikasiMassalController,
    OneSignalController,
    LaporanController,
    SettingsController,
    ProfileController
};

use App\Http\Controllers\Mobile\SettingController;
use App\Http\Controllers\Mobile\JadwalController;
use App\Http\Controllers\Mobile\CatatanController;
use App\Http\Controllers\Mobile\PostsController;
use Illuminate\Support\Facades\Broadcast;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });

use NotificationChannels\WebPush\WebPushMessage;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\TestWebPushNotification;


Route::get('/test-webpush', function () {
    $user = User::find(2); // Ganti dengan ID user yang sudah subscribe

    $user->notify(new TestWebPushNotification());

    return 'Notifikasi dikirim!';
});

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->post('/webpush/subscribe', function (\Illuminate\Http\Request $request) {
    $request->user()->updatePushSubscription(
        $request->endpoint,
        $request->keys['p256dh'],
        $request->keys['auth']
    );
    return response()->json(['status' => 'subscribed']);
});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => 'level:1'], function () {
        Route::resource('/user', UserController::class);
        Route::resource('suplemen', SuplemenController::class);
        Route::resource('posts', PostController::class);
        Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
        Route::resource('setting-notifikasi', NotificationSettingController::class)->only(['index', 'store', 'edit']);
        Route::get('/notifikasi/massal', [NotifikasiMassalController::class, 'index'])->name('notifikasi.massal');
        Route::post('/notifikasi/kirim-massal', [NotifikasiMassalController::class, 'kirim'])->name('notifikasi.kirim.massal');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.export');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/profil', [ProfileController::class, 'profil'])->name('profil.index');
        Route::post('/profil/{id}', [ProfileController::class, 'update'])->name('profil.update');
    });
    // Route::group(['middleware' => 'level:1,2'], function () {
    //     Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    //     Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
    // });
});

Route::post('/onesignal/store', [OneSignalController::class, 'store'])->name('onesignal.store');
Broadcast::routes(['middleware' => ['auth']]);


Route::prefix('mobile')->group(function () {
    Route::get('register', [\App\Http\Controllers\Mobile\AuthController::class, 'showRegisterForm'])->name('mobile.register');
    Route::post('register', [\App\Http\Controllers\Mobile\AuthController::class, 'register'])->name('register.submit');

    Route::get('login', [\App\Http\Controllers\Mobile\AuthController::class, 'showLoginForm'])->name('mobile.login');
    Route::post('login', [\App\Http\Controllers\Mobile\AuthController::class, 'login'])->name('login.submit');

    Route::middleware(['auth'])->group(function () {
        Route::get('settings', [SettingController::class, 'edit'])->name('mobile.settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('mobile.settings.update');
        Route::put('/settings/profile', [SettingController::class, 'updateProfile'])->name('mobile.settings.updateProfile');
        Route::put('/settings/password', [SettingController::class, 'changePassword'])->name('mobile.settings.changePassword');
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('mobile.jadwal.index');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('mobile.jadwal.store');
        Route::get('/catatan', [CatatanController::class, 'index'])->name('catatan.index');
        Route::post('/catatan', [CatatanController::class, 'store'])->name('catatan.store');
        Route::post('/logout', [\App\Http\Controllers\Mobile\AuthController::class, 'logout'])->name('mobile.logout');
        Route::get('/posts', [PostsController::class, 'index'])->name('mobile.posts.index');
        Route::get('/posts/{id}', [PostsController::class, 'show'])->name('mobile.posts.show');

        //Broadcast::routes();
    });
});
