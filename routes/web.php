<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminBerandaController;
use App\Http\Controllers\AdminAgendaController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminKegiatanController;
use App\Http\Controllers\AdminPengumumanController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WelcomeDetailController;
use App\Http\Controllers\AdminPublikasiController;
use App\Http\Controllers\AdminGaleriFotoController;
use App\Http\Controllers\AdminGaleriVideoController;
use App\Http\Controllers\AdminInfografisController;
use App\Http\Controllers\AdminSusunanRedaksiController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\Auth\LoginController;

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
    return view('welcome');
});

Auth::routes();
Route::get('auth/login_new', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('auth/login_new', [LoginController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/admin-theme', AdminThemeController::class);
    Route::resource('/admin-beranda', AdminBerandaController::class);
    Route::resource('/admin-agenda', AdminAgendaController::class);
    Route::resource('/admin-susunan-redaksi', AdminSusunanRedaksiController::class);
    Route::get('/admin-susunan-redaksi-detail/{id}',[AdminSusunanRedaksiController::class, 'getUserDetails'])->name('user.details');
    Route::get('/admin-susunan-redaksi-detail-chart',[AdminSusunanRedaksiController::class, 'chartOrg'])->name('user.chart');
    Route::get('/admin-susunan-redaksi-divisi',[AdminSusunanRedaksiController::class, 'divisi_create'])->name('user.divisi');
    Route::post('admin-susunan-redaksi-divisi-store',[AdminSusunanRedaksiController::class, 'store_divisi'])->name('admin-susunan-redaksi-divisi-store');
    Route::get('/admin-susunan-redaksi-jabatan',[AdminSusunanRedaksiController::class, 'jabatan_create'])->name('user.jabatan');
    Route::post('admin-susunan-redaksi-jabatan-store',[AdminSusunanRedaksiController::class, 'store_jabatan'])->name('admin-susunan-redaksi-jabatan-store');
    Route::resource('/admin-berita', AdminBeritaController::class);
    Route::resource('/admin-kegiatan', AdminKegiatanController::class);
    Route::resource('/admin-pengumuman', AdminPengumumanController::class);
    Route::resource('/admin-publikasi', AdminPublikasiController::class);
    Route::resource('/admin-galeri-foto', AdminGaleriFotoController::class);
    Route::resource('/admin-galeri-video', AdminGaleriVideoController::class);
    Route::resource('/admin-infografis', AdminInfografisController::class);
    Route::resource('/admin-setting', AdminSettingController::class);
    Route::get('/admin-setting-social-media', [AdminSettingController::class, 'edit_social_media'])->name('user.jabatan');
    Route::post('/admin-setting-social-media-store',[AdminSusunanRedaksiController::class, 'store_divisi'])->name('admin-susunan-redaksi-divisi-store');

});

Route::resource('/beranda', BerandaController::class);
Route::resource('/', WelcomeController::class);
// Route::resource('/agenda', WelcomeController::class);
Route::get('/agenda',[WelcomeController::class, 'agenda'])->name('agenda.index');
Route::get('/berita',[WelcomeController::class, 'berita'])->name('berita.index');
Route::get('/kegiatan',[WelcomeController::class, 'kegiatan'])->name('kegiatan.index');
Route::get('/detail/{id}/{type}',[WelcomeController::class, 'detail'])->name('detail');
Route::get('/pengumuman',[WelcomeController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/tujuan',[WelcomeController::class, 'tujuan'])->name('tujuan.index');
Route::get('/tentang-kami',[WelcomeController::class, 'tentang_kami'])->name('visi_misi.index');
Route::get('/visi-misi',[WelcomeController::class, 'visi_misi'])->name('visi_misi.index');
Route::get('/publikasi',[WelcomeController::class, 'publikasi'])->name('publikasi.index');
Route::get('/galeri-foto',[WelcomeController::class, 'galeri_foto'])->name('galeri_foto.index');
Route::get('/galeri-video',[WelcomeController::class, 'galeri_video'])->name('galeri_video.index');
Route::get('/infografis',[WelcomeController::class, 'infografis'])->name('infografis.index');
Route::get('/kontak',[WelcomeController::class, 'kontak'])->name('kontak.index');
Route::get('/susunan-redaksi',[WelcomeController::class, 'susunan_redaksi'])->name('susunan_redaksi.index');




