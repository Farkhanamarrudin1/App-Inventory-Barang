<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\GoodsReceiptController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default → redirect ke login
Route::get('/', function () {
    return redirect('/login');
});


// =============================
// 🔐 AUTHENTICATION
// =============================
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSimpan')->name('register.simpan');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAksi')->name('login.aksi');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});


// =============================
// 🔒 ROUTE KHUSUS USER LOGIN
// =============================
Route::middleware('auth')->group(function () {

    // =============================
    // 🏠 DASHBOARD
    // =============================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔍 Search dari topbar dashboard
    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');


    // =============================
    // 📦 BARANG
    // =============================
    Route::controller(BarangController::class)->prefix('barang')->group(function () {

        Route::get('/', 'index')->name('barang');
        Route::get('tambah', 'tambah')->name('barang.tambah');
        Route::post('tambah', 'simpan')->name('barang.tambah.simpan');

        Route::get('edit/{id}', 'edit')->name('barang.edit');
        Route::post('edit/{id}', 'update')->name('barang.update');

        Route::get('hapus/{id}', 'hapus')->name('barang.hapus');

        // 🔍 Search barang
        Route::get('search', 'search')->name('barang.search');
    });


    // =============================
    // 🏷️ KATEGORI
    // =============================
    Route::controller(KategoriController::class)->prefix('kategori')->group(function () {

        Route::get('/', 'index')->name('kategori');
        Route::get('tambah', 'tambah')->name('kategori.tambah');
        Route::post('tambah', 'simpan')->name('kategori.tambah.simpan');

        Route::get('edit/{id}', 'edit')->name('kategori.edit');
        Route::post('edit/{id}', 'update')->name('kategori.update');

        Route::get('hapus/{id}', 'hapus')->name('kategori.hapus');
    });


    // =============================
    // 📄 LAPORAN
    // =============================
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/download', [LaporanController::class, 'downloadPDF'])->name('laporan.download');


    // ============================================================
    // 📌 PURCHASING MODULE (Purchase Request → PO → Goods Receipt)
    // ============================================================

    // --- Purchase Request (PR)
    Route::prefix('pr')->name('pr.')->group(function () {
        Route::get('/', [PurchaseRequestController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseRequestController::class, 'create'])->name('create');
        Route::post('/store', [PurchaseRequestController::class, 'store'])->name('store');
        Route::get('/{id}', [PurchaseRequestController::class, 'show'])->name('show');
        Route::delete('/{id}', [PurchaseRequestController::class, 'destroy'])->name('delete');
    });

    // --- Purchase Order (PO)
    Route::prefix('po')->name('po.')->group(function () {
        Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
        Route::get('/create/{pr_id}', [PurchaseOrderController::class, 'create'])->name('create.from.pr');
        Route::post('/store', [PurchaseOrderController::class, 'store'])->name('store');
        Route::get('/detail/{id}', [PurchaseOrderController::class, 'show'])->name('show');
    });

    // --- Goods Receipt (GR)
    Route::prefix('gr')->name('gr.')->group(function () {
        Route::get('/', [GoodsReceiptController::class, 'index'])->name('index');
        Route::get('/create/{po_id}', [GoodsReceiptController::class, 'create'])->name('create.from.po');
        Route::post('/store', [GoodsReceiptController::class, 'store'])->name('store');
        Route::get('/detail/{id}', [GoodsReceiptController::class, 'show'])->name('show');
    });

    // 📌 Purchase Request Approval (Supervisor)
    Route::prefix('purchase-requests')->middleware('auth')->group(function () {
    Route::get('/', [PurchaseRequestController::class, 'index'])->name('purchase_requests.index');
    Route::get('/{id}', [PurchaseRequestController::class, 'show'])->name('purchase_requests.show');
    Route::post('/{id}/approve', [PurchaseRequestController::class, 'approve'])->name('purchase_requests.approve');
    Route::post('/{id}/reject', [PurchaseRequestController::class, 'reject'])->name('purchase_requests.reject');
    });

    // Approval PR (Supervisor only)
    Route::prefix('pr')->controller(PurchaseRequestController::class)->group(function () {
    Route::post('/{id}/approve', 'approve')->name('pr.approve');
    Route::post('/{id}/reject', 'reject')->name('pr.reject');
    Route::post('/pr/{id}/approve', 'approve')->middleware('role:Supervisor');
    Route::post('/pr/{id}/reject', 'reject')->middleware('role:Supervisor');
    });

});