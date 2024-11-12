<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlamatTransaksiController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\NelayanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeafoodController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\NelayanSettingController;
use App\Http\Controllers\ProfileNelayanController;
use App\Http\Controllers\BarangsewaController;
use App\Http\Controllers\KeranjangController;

Route::get('/', function () {
    return view('welcome');
})->name('index');

//login-google
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle'])->name('callbackGoogle');

//login-facebook
Route::get('/auth/facebook', [FacebookAuthController::class, 'redirect'])->name('facebook-auth');
Route::get('/auth/facebook/call-back', [FacebookAuthController::class, 'callbackFacebook'])->name('callbackFacebook');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/about-information/fishapp', function () {
    return view('about_information');
})->name('about_information');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/pdatefoto', [ProfileController::class, 'updatefoto'])->name('update.profile.photo');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/about2', function () {
        return view('about2');
    })->name('about2');
    Route::get('/about-information2/fishapp', function () {
        return view('about_information2');
    })->name('about_information2');

    Route::prefix('keranjang')->group(function () {
        Route::get('/index', [KeranjangController::class, 'index'])->name('keranjang.pembeli');
        Route::post('/deleteitemkeranjang/{kodeBarangString}', [KeranjangController::class, 'deleteItems'])->name('deleteitemkeranjang');
    });

    Route::prefix('alamat/user/pengiriman/seafood')->group(function (){
        Route::get('/index', [AlamatTransaksiController::class, 'alamatpembeli'])->name('alamat.pengiriman.pembeli');
        Route::post('/create/alamat/tujuan/seafood', [AlamatTransaksiController::class, 'createalamattujuan'])->name('createalamat.pembeli.seafood');
        Route::delete('/alamat-seafood/{id}', [AlamatTransaksiController::class, 'destroy'])->name('delete.alamat.seafood');
    });

    Route::prefix('user/produk')->group(function () {
        Route::get('/seafood', [SeafoodController::class, 'seafooduser'])->name('pembeli.produk.seafood');
        Route::get('/barangsewa', [BarangsewaController::class, 'barangsewauser'])->name('pembeli.produk.barangsewa');
        Route::get('/hubungi/penjual/{id}', [SeafoodController::class, 'chatwa'])->name('hubungi.penjual.seafood');
        Route::get('/beli/seafood/{kode_seafood}', [SeafoodController::class, 'beli'])->name('beliseafood');
        Route::get('/add-to-cart/{productId}/{jumlah}/{subtotal}', [SeafoodController::class, 'addchart'])->name('addchartseafood');
        Route::post('/checkout/seafood', [KeranjangController::class, 'processCheckoutseafood'])->name('checkout.route');
    });
});

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'login'])->name('login_admin');
    Route::post('login/post', [AdminController::class, 'store'])->name('admin.login');
    Route::get('/forgot-password', [AdminController::class, 'adminresetpassword'])->name('admin.password.request');
    Route::post('/forgot-password/post', [AdminController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/forgot-password/{token}', [AdminController::class, 'reseturl'])->name('admin.password.reseturl');
    Route::post('/forgot-password/{token}/{email}', [AdminController::class, 'processResetPassword'])->name('admin.password.update');
    Route::middleware('is_admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
        Route::get('/viewdatanelayan', [AdminController::class, 'viewdatanelayan'])->name('viewdatanelayan');
        Route::get('/viewdata-pendaftaran', [AdminController::class, 'permintaannelayanakun'])->name('viewdatapermintaannelayan');
        Route::get('/checkpenjualan', [AdminController::class, 'checkpenjualan'])->name('checkpenjualan');
        Route::get('/dataseafood', [AdminController::class, 'dataseafood'])->name('dataseafood');
        Route::get('/detail-permintaan/pendaftaran/akun/{id}', [AdminController::class, 'detailpermintaan'])->name('detailpermintaanakunnelayan');
        Route::post('/tolakakunnelayan/{id}', [AdminController::class, 'tolakakunnelayan'])->name('tolakakunnelayan');
        Route::post('/verifikasinelayan/{id}', [AdminController::class, 'verifikasinelayan'])->name('verifikasi.nelayan');
        Route::post('/verifikasi/seafood/{id}', [AdminController::class, 'verifikasiseafood'])->name('admin.verifikasi.seafood');
        Route::get('/detail-seafood/{id}', [AdminController::class, 'detailpermintaanseafood'])->name('admin.view.detail.seafood');
        Route::post('/tolakseafood/{id}', [AdminController::class, 'tolakseafood'])->name('tolakseafood.admin');
        Route::get('/daftar-permintaan/alat/barang-sewa', [AdminController::class, 'permintaanbarangsewa'])->name('checkpenyewaanalat.nelayan');
        Route::get('/detail-barang/{id}', [AdminController::class, 'detailpermintaanbarang'])->name('admin.view.detail.permintaan.barang');
        Route::post('/verifikasi/alat/{id}', [AdminController::class, 'verifikasibarang'])->name('admin.verifikasi.barang');
        Route::post('/tolakbarang/{id}', [AdminController::class, 'tolakbarang'])->name('tolakbarang.admin');
    });
});

Route::get('/api/villages', [NelayanController::class, 'villages']);
Route::get('/produk/seafoods', [SeafoodController::class, 'seafoodguest'])->name('seafood.guest');
Route::get('/produk/barangsewas', [BarangsewaController::class, 'barangsewaguest'])->name('barangsewa.guest');
Route::get('/article', [ArticleController::class, 'index'])->name('guestarticle');

Route::prefix('nelayan')->group(function () {
    Route::get('form-registraton', [NelayanController::class, 'registration'])->name('form_registrasi_nelayan');
    Route::post('form-registraton/post', [NelayanController::class, 'store'])->name('post_form_pendaftaran_nelayan');
    Route::get('login', [NelayanController::class, 'login'])->name('login_nelayan');
    Route::post('login/post', [NelayanController::class, 'loginpost'])->name('nelayan.login');
    Route::get('/registered/{email}/{token}', [NelayanController::class, 'regnel'])->name('nelayan.regnel');
    Route::post('registered-process/{token}', [NelayanController::class, 'processregistrasi'])->name('nelayan.registereduser');
    Route::get('/forgot-password', [NelayanController::class, 'nelayanresetpassword'])->name('nelayan.password.request');
    Route::post('/forgot-password/post', [NelayanController::class, 'sendResetLinkEmail'])->name('nelayan.password.email');
    Route::get('/forgot-password/{token}', [NelayanController::class, 'reseturl'])->name('nelayan.password.reseturl');
    Route::post('/forgot-password/{token}/{email}', [NelayanController::class, 'processResetPassword'])->name('nelayan.password.update');
    Route::middleware('nelayan')->group(function () {
        Route::get('dashboard', [NelayanController::class, 'dashboard'])->name('nelayan.dashboard');
        Route::get('/logout', [NelayanController::class, 'NelayanLogout'])->name('nelayan.logout');
        Route::get('/profile', [ProfileNelayanController::class, 'index'])->name('nelayan.profile');
        Route::post('/update-profile-photo-nelayan', [ProfileNelayanController::class, 'uploadpotouser'])->name('update.profile.photo.nelayan');
        Route::delete('/delete-profile-photo-nelayan', [ProfileNelayanController::class, 'deletepotouser'])->name('delete.profile.photo.nelayan');
        Route::post('/nelayan-profile', [ProfileNelayanController::class, 'update'])->name('nelayan.profile.update');
        Route::post('/nelayan-profile/createbank', [ProfileNelayanController::class, 'createbank'])->name('nelayan.profile.create.bank');
        Route::post('/nelayan-profile/updatebank/{id}', [ProfileNelayanController::class, 'updatebank'])->name('nelayan.profile.update.bank');
        Route::post('/nelayan-profile/deletebank/{id}', [ProfileNelayanController::class, 'deletebank'])->name('nelayan.profile.delete.bank');
        Route::get('/pengaturan', [NelayanSettingController::class, 'index'])->name('nelayan.pengaturan');
        route::post('/pengaturan/updatename', [NelayanSettingController::class, 'updatenamenelayan'])->name('nelayan.updatename');
        route::post('/pengaturan/updatepassword', [NelayanSettingController::class, 'newpasswordnelayan'])->name('nelayan.newpassword');
        Route::prefix('barangsewa')->group(function(){
            Route::get('/', [BarangsewaController::class, 'index'])->name('barangsewa.index');
            Route::get('/create-barangsewa', [BarangsewaController::class, 'create'])->name('create.barangsewa');
            Route::post('/create-barangsewa/post', [BarangsewaController::class, 'store'])->name('barang.store');
        });
        Route::prefix('seafood')->group(function(){
            Route::get('/', [SeafoodController::class, 'index'])->name('sefood.index');
            Route::get('/create-seafood', [SeafoodController::class, 'create'])->name('create.seafood');
            Route::post('/create-seafood/post', [SeafoodController::class, 'store'])->name('sefood.store');
            Route::get('/detail-seafood/{kode_seafood}', [SeafoodController::class, 'detail'])->name('seafood.detail.nelayan');
            Route::get('/edit-seafood/{kode_seafood}', [SeafoodController::class, 'edit'])->name('seafood.edit.nelayan');
            Route::post('/edit-seafood/{id}/post', [SeafoodController::class, 'editseafood'])->name('edit.seafood');
            Route::post('/edit-seafood/{kode_seafood}/delete', [SeafoodController::class, 'deleteseafood'])->name('nealayan.deleteseafood');
        });
        Route::prefix('pesanan')->group(function(){
            Route::get('/seafood', [SeafoodController::class, 'pesananseafoodnelayan'])->name('nelayan.pesanan.seafood');
            Route::get('/detailpesananseafood', [SeafoodController::class, 'detailpesananseafood'])->name('detailpesananseafood');
            Route::get('/barangsewa', [BarangsewaController::class, 'pesananbarangsewanelayan'])->name('nelayan.pesanan.barangsewa');
            Route::get('/detailpesananbarangsewa', [BarangsewaController::class,'detailpesananbarangsewa'])->name('detailpesananbarangsewa.nelayan');
        });
    });
});

require __DIR__ . '/auth.php';
