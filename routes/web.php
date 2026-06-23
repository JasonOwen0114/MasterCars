<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JualController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MobilController;

    Route::get('/compare', [DashboardController::class, 'compareForm'])
        ->name('compare.form');

    Route::get('/compare/result', [DashboardController::class, 'compareResult'])
        ->name('compare.result');

    Route::get('/jual/models/{merk}', [JualController::class, 'getModelByMerk']);

    Route::get('/mobil/{mobil}', [MobilController::class, 'detail'])
        ->name('mobil.detail');

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'loginProses']);

    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'registerProses']);

});


Route::middleware('auth')->group(function () {

    Route::post('/booking/{mobil}', [MobilController::class, 'booking'])
        ->name('booking.store');

    Route::get('/profile', [UserController::class, 'profile'])
        ->name('user.profile');

    Route::post('/profile', [UserController::class, 'updateProfile'])
        ->name('user.profile.update');

    Route::post('/profile/password', [UserController::class, 'updatePassword'])
        ->name('user.profile.password');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/jual', [JualController::class, 'jual1'])->name('jual1');

    Route::post('/jual', [JualController::class, 'storeStep1']);


    Route::get('/jual/step-2', fn () => view('jual2'))->name('jual2');

    Route::post('/jual/step-2', [JualController::class, 'storeStep2']);

    Route::get('/payment/finish', [JualController::class, 'paymentFinish']);

    Route::get('/payment/failed', [JualController::class, 'paymentFailed']);

    Route::get('/inspeksi', [UserController::class, 'index'])
        ->name('user.inspeksi');
        
    Route::get('/inspeksi/{mobil}', [UserController::class, 'hasil'])
        ->name('user.inspeksi.hasil');

    Route::post('/mobil/{mobil}/status-jual', [UserController::class, 'pilihStatusJual'])
        ->name('mobil.statusJual');

    Route::post('/mobil/{mobil}/jual', [UserController::class, 'simpanJual'])
        ->name('mobil.simpanJual');

    Route::post('/mobil/{mobil}/jual', [UserController::class, 'simpanJual'])
        ->name('mobil.simpanHarga');

    Route::get('/cek-slot/{tanggal}', [JualController::class,'cekSlot']);

Route::get('/booking/finish', [MobilController::class, 'paymentFinishBooking'])
    ->name('payment.finish.booking');

Route::get('/booking/failed', [MobilController::class, 'paymentFailedBooking'])
    ->name('payment.failed.booking');

    Route::get('/mobil-saya', [UserController::class, 'mobilSaya'])
        ->name('user.mobilSaya');

    Route::get('/mobil-saya/{mobil}', [UserController::class, 'detailMobilSaya'])
        ->name('user.mobilSaya.detail');

    Route::get('/cek-slot/{tanggal}', [UserController::class, 'cekSlot']);

    Route::get('/reinspeksi/bayar/{mobil}', [UserController::class, 'bayarReinspeksi']);

Route::get('/reinspeksi/finish', [UserController::class, 'finishReinspeksi'])
    ->name('reinspeksi.finish');

    Route::get('/laporan-inspeksi', [UserController::class, 'laporanReinspeksi'])
        ->name('laporan.reinspeksi');

    Route::get('/reinspeksi/hasil/{id}', [UserController::class, 'hasilReinspeksi'])
        ->name('reinspeksi.hasil');

    Route::post('/mobil/{mobil}/inspeksi-ulang', [UserController::class, 'inspeksiUlang'])
        ->name('mobil.inspeksiUlang');

    Route::post('/mobil/{mobil}/reinspeksi', [UserController::class, 'reinspeksi'])
        ->name('mobil.reinspeksi');

    Route::delete('/mobil-saya/{mobil}', [UserController::class, 'hapusMobil'])
        ->name('user.mobilSaya.hapus');
        
    Route::get('/approval-inspeksi', [UserController::class, 'approvalInspeksi'])
        ->name('user.approval');
    Route::post('/notification/read', [DashboardController::class,'readNotification'])
        ->name('notification.read');
});


// Route::middleware(['auth', 'role:1'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::post('/admin/assign/{id}', [AdminController::class, 'storeAssign'])->name('admin.assign.store');
//     Route::get('/admin/add-staff', [AdminController::class, 'createStaff'])->name('admin.staff.create');
//     Route::post('/admin/add-staff', [AdminController::class, 'storeStaff'])->name('admin.staff.store');
//     Route::get('/admin/assign-booking', [AdminController::class, 'assignBooking'])->name('admin.booking');
//     Route::post('/admin/assign-booking/{id}', [AdminController::class, 'assignDelivery'])->name('admin.booking.assign');
//     Route::get('/admin/reinspeksi', [AdminController::class, 'reinspeksiList'])
//         ->name('admin.reinspeksi');
//     Route::get('/admin/laporan', [AdminController::class, 'laporan'])
//     ->name('admin.laporan');
// });
Route::middleware(['auth', 'role:1'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::post('/admin/assign/{id}', [AdminController::class, 'storeAssign'])
        ->name('admin.assign.store');

    Route::get('/admin/add-staff', [AdminController::class, 'createStaff'])
        ->name('admin.staff.create');

    Route::post('/admin/add-staff', [AdminController::class, 'storeStaff'])
        ->name('admin.staff.store');

    Route::get('/admin/assign-booking', [AdminController::class, 'assignBooking'])
        ->name('admin.booking');

    Route::post('/admin/assign-booking/{id}', [AdminController::class, 'assignDelivery'])
        ->name('admin.booking.assign');

    Route::get('/admin/reinspeksi', [AdminController::class, 'reinspeksiList'])
        ->name('admin.reinspeksi');

    Route::redirect('/admin/laporan', '/admin/laporan/staff')
        ->name('admin.laporan');

    Route::get('/admin/laporan/staff', [AdminController::class, 'laporanKinerjaStaff'])
        ->name('admin.laporan.staff');

    Route::get('/admin/laporan/pendapatan', [AdminController::class, 'laporanPendapatanBulanan'])
        ->name('admin.laporan.pendapatan');

    Route::get('/admin/laporan/jadwal-terpadat', [AdminController::class, 'laporanJadwalTerpadat'])
        ->name('admin.laporan.jadwalTerpadat');

    Route::get('/admin/laporan/jadwal-inspeksi', [AdminController::class, 'laporanJadwalInspeksi'])
        ->name('admin.laporan.jadwal');

    Route::get('/admin/laporan/waktu-penjualan', [AdminController::class, 'laporanWaktuPenjualan'])
        ->name('admin.laporan.waktuPenjualan');

    Route::get('/admin/laporan/pendapatan-inspeksi', [AdminController::class, 'laporanPendapatanInspeksi'])
        ->name('admin.laporan.pendapatanInspeksi');

    Route::get('/admin/laporan/mobil-tahun', [AdminController::class, 'laporanMobilPerTahun'])
        ->name('admin.laporan.mobilTahun');

    Route::get('/admin/laporan/hasil-inspeksi', [AdminController::class, 'laporanHasilInspeksi'])
        ->name('admin.laporan.hasilInspeksi');

    Route::get('/admin/laporan/penjualan', [AdminController::class, 'laporanPenjualanMobil'])
        ->name('admin.laporan.penjualan');

    Route::get('/admin/laporan/mobil-aktif', [AdminController::class, 'laporanMobilAktif'])
        ->name('admin.laporan.mobilAktif');

    Route::get('/admin/models/{merk}', [AdminController::class, 'getModelByMerk']);

    Route::get('/admin/tambah-mobil', [AdminController::class, 'tambahMobil'])
    ->name('admin.tambahMobil');

    Route::post('/admin/merk/store', [AdminController::class, 'storeMerk'])
        ->name('admin.merk.store');

    Route::post('/admin/model/store', [AdminController::class, 'storeModel'])
        ->name('admin.model.store');

    Route::delete('/admin/data-mobil/delete', [AdminController::class, 'deleteDataMobil'])
        ->name('admin.dataMobil.delete');
});
Route::middleware(['auth', 'role:2'])->group(function () {

    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])
        ->name('staff.dashboard');

    Route::get('/staff/inspeksi/{id}', [StaffController::class, 'formInspeksi'])
        ->name('staff.inspeksi.form');

    Route::post('/staff/inspeksi/{id}', [StaffController::class, 'simpanInspeksi'])
        ->name('staff.inspeksi.simpan');

    Route::get('/staff/booking', [StaffController::class, 'booking'])
        ->name('staff.booking');

    Route::post('/staff/booking/{id}/accept', [StaffController::class, 'acceptBooking'])
        ->name('staff.booking.accept');

    Route::post('/staff/booking/{id}/kirim', [StaffController::class, 'kirimBooking'])
        ->name('staff.booking.kirim');
    Route::post('/staff/booking/{id}/upload-foto',[StaffController::class, 'uploadFotoSerahTerima'])
        ->name('staff.booking.uploadFoto');
}
);
Route::get('/cloudinary-debug', function () {
    return response()->json([
        'url' => config('cloudinary.cloud_url'),
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'key' => env('CLOUDINARY_API_KEY'),
        'secret' => !empty(env('CLOUDINARY_API_SECRET')),
    ]);
});
Route::get('/cloudinary-provider', function () {

    $file = base_path(
        'vendor/cloudinary-labs/cloudinary-laravel/src/CloudinaryServiceProvider.php'
    );

    if (!file_exists($file)) {
        return 'File tidak ditemukan';
    }

    $lines = file($file);

    return '<pre>' .
        htmlspecialchars(
            implode('', array_slice($lines, 55, 20))
        ) .
        '</pre>';
});