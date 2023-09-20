<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemNoteController;
use App\Http\Controllers\ItemTransaksiController;
use App\Http\Controllers\JenisItemController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanInventoryController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PackingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaketCuciController;
use App\Http\Controllers\PaketDepositController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PickupDeliveryController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RewashController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\DiskonTransaksiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

Route::get('/printNota/{id}', [PrintController::class, 'nota']);
Route::get('/printMemoProduksi/{id}', [PrintController::class, 'memoProduksi']);
Route::get('/printKitir/{id}', [PrintController::class, 'kitir']);
Route::get('/printPreview/{id}', [PrintController::class, 'preview']);

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate']);
});
Route::get('/logout', [UserController::class, 'logout']);
//Middleware Auth digunakan ketika Sudah Login
Route::middleware(['auth'])->group(function () {
    Route::get('/reset-password', [PageController::class, 'resetPassword'])->name('reset_password');

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::get('/setting/hak-akses/list', [PermissionController::class, 'permissionList']); //Ngambil List SEMUA Permission
    Route::get('/setting/hak-akses/role/{role}', [PermissionController::class, 'rolesPermissionList']); //Ngambil List Permission KHUSUS ROLE Tertentu
    Route::post('/setting/hak-akses/role/{role}/sync', [PermissionController::class, 'syncPermission']); //Ngambil List Permission KHUSUS ROLE Tertentu
    //Setting

    //Karyawan
    Route::get('/setting/karyawan', [PageController::class, 'karyawan'])->name('menu-karyawan');
    Route::get('/setting/karyawan/{id}', [UserController::class, 'show']);
    Route::post('/setting/karyawan', [UserController::class, 'insert']);
    Route::post('/setting/karyawan/outlet', [UserController::class, 'updateOutlet']);
    Route::post('/setting/karyawan/{id}', [UserController::class, 'update']);
    Route::post('/setting/karyawan/{user}/change-password', [UserController::class, 'changePassword']);
    Route::get('/component/karyawan', [PageController::class, 'listKaryawan']);

    //outlet
    Route::get('/setting/outlet', [PageController::class, 'outlet'])->name('menu-outlet');
    Route::get('/setting/outlet/{id}', [OutletController::class, 'show']);
    Route::post('/setting/outlet', [OutletController::class, 'insert']);
    Route::post('/setting/outlet/{id}', [OutletController::class, 'update']);
    Route::get('/setting/outlet/delete/{id}', [OutletController::class, 'delete']);
    Route::post('/setting/outlet/update-saldo/{outlet}', [OutletController::class, 'updateSaldo']);
    Route::get('/component/outlet', [OutletController::class, 'component']);

    //Paket Cuci
    Route::get('/setting/paket-cuci', [PageController::class, 'paketCuci'])->name('menu-paket-cuci');
    Route::get('/setting/paket-cuci/{id}', [PaketCuciController::class, 'show']);
    Route::post('/setting/paket-cuci', [PaketCuciController::class, 'insert']);
    Route::post('/setting/paket-cuci/{id}', [PaketCuciController::class, 'update']);
    Route::get('/setting/paket-cuci/delete/{id}', [PaketCuciController::class, 'delete']);

    //Paket Deposit
    Route::get('/setting/paket-deposit', [PageController::class, 'paketDeposit'])->name('menu-paket-deposit');
    Route::get('/setting/paket-deposit/{id}', [PaketDepositController::class, 'show']);
    Route::post('/setting/paket-deposit', [PaketDepositController::class, 'insert']);
    Route::post('/setting/paket-deposit/{id}', [PaketDepositController::class, 'update']);
    Route::get('/setting/paket-deposit/delete/{id}', [PaketDepositController::class, 'delete']);

    //item
    Route::get('/data/jenis-item', [PageController::class, 'jenisItem'])->name('menu-jenis-item');
    Route::get('/data/jenis-item/find', [JenisItemController::class, 'find']);
    Route::get('/data/jenis-item/{id}', [JenisItemController::class, 'show']);
    Route::post('/data/jenis-item', [JenisItemController::class, 'insert']);
    Route::post('/data/jenis-item/{id}', [JenisItemController::class, 'update']);
    Route::get('/data/jenis-item/delete/{id}', [JenisItemController::class, 'delete']);
    Route::get('/component/jenis-item', [JenisItemController::class, 'componentFind']);

    //Kategori
    Route::get('/data/kategori', [PageController::class, 'kategori'])->name('menu-kategori');
    Route::get('/data/kategori/{id}', [KategoriController::class, 'show']);
    Route::post('/data/kategori', [KategoriController::class, 'insert']);
    Route::post('/data/kategori/{id}', [KategoriController::class, 'update']);
    Route::get('/data/kategori/delete/{id}', [KategoriController::class, 'delete']);

    //pengeluaran
    Route::get('/data/pengeluaran', [PageController::class, 'pengeluaran'])->name('menu-pengeluaran');
    Route::get('/data/pengeluaran/{id}', [PengeluaranController::class, 'show']);
    Route::post('/data/pengeluaran', [PengeluaranController::class, 'insert']);
    Route::post('/data/pengeluaran/{id}', [PengeluaranController::class, 'update']);
    Route::get('/data/pengeluaran/delete/{id}', [PengeluaranController::class, 'delete']);

    //Parfum
    Route::get('/data/parfum', [PageController::class, 'parfum'])->name('menu-parfum');
    Route::get('/data/parfum/{id}', [ParfumController::class, 'show']);
    Route::post('/data/parfum', [ParfumController::class, 'insert']);
    Route::post('/data/parfum/{id}', [ParfumController::class, 'update']);
    Route::get('data/parfum/delete/{id}', [ParfumController::class, 'delete']);

    //Pelanggan
    Route::get('/data/pelanggan', [PageController::class, 'pelanggan'])->name('menu-pelanggan');
    Route::get('/data/pelanggan/{id}', [PelangganController::class, 'show']);
    Route::post('/data/pelanggan', [PelangganController::class, 'insert']);
    Route::post('/data/pelanggan/{id}', [PelangganController::class, 'update']);
    Route::get('/data/pelanggan/delete/{id}', [PelangganController::class, 'delete']);
    Route::get('/component/pelanggan', [PelangganController::class, 'search']);

    //Rewash data
    Route::get('/data/rewash', [PageController::class, 'dataRewash'])->name('data-rewash');
    Route::post('/data/rewash', [RewashController::class, 'insertData']);
    Route::get('/data/rewash/delete/{id}', [RewashController::class, 'deleteData']);

    // Diskon
    Route::get('/data/diskon', [PageController::class, 'diskon'])->name('data-diskon');
    Route::post('/data/diskon', [DiskonController::class, 'insert']);
    Route::post('/data/diskon/{diskon}', [DiskonController::class, 'update']);
    Route::get('/data/diskon/delete/{id}', [DiskonController::class, 'delete']);

    //Pickup & Delivery
    Route::get('/transaksi/pickup-delivery', [PageController::class, 'pickupDelivery'])->name('pickup-delivery');
    Route::get('/transaksi/pickup-delivery/{id}', [PickupDeliveryController::class, 'show']);
    Route::post('/transaksi/pickup-delivery', [PickupDeliveryController::class, 'insert']);
    Route::post('/transaksi/pickup-delivery/{id}', [PickupDeliveryController::class, 'update']);
    Route::get('/transaksi/pickup-delivery/delete/{id}', [PickupDeliveryController::class, 'delete']);
    Route::get('/component/pickup', [PickupDeliveryController::class, 'pickup']);
    Route::get('/component/delivery', [PickupDeliveryController::class, 'delivery']);
    Route::get('/component/ambil_di_outlet', [PickupDeliveryController::class, 'ambil_di_outlet']);
    Route::get('/transaksi/pickup-delivery/task-hub', [PickupDeliveryController::class, 'showTaskHub']);
    Route::get('/transaksi/pickup-delivery/{pickup_delivery}/is-done', [PickupDeliveryController::class, 'changeDoneStatus']);

    //Catatan Item Transaksi //ItemTransaksi
    Route::get('/transaksi/item-transaksi/{id}', [ItemTransaksiController::class, 'show']);
    Route::post('/transaksi/item-transaksi', [ItemTransaksiController::class, 'insert']);
    Route::post('/transaksi/item-transaksi/{id}', [ItemTransaksiController::class, 'update']);
    Route::post('/transaksi/item-transaksi/{id}/qty', [ItemTransaksiController::class, 'updateQty']);
    Route::get('/transaksi/item-transaksi/delete/{id}', [ItemTransaksiController::class, 'delete']);
    Route::get('/transaksi/{transaksi_id}/item-transaksi/rewash-status', [ItemTransaksiController::class, 'getItemAndStatus']);

    //ItemNote
    Route::get('/transaksi/item/note/{id}', [ItemNoteController::class, 'show']);
    Route::post('/transaksi/item/note/add', [ItemNoteController::class, 'insert']);
    Route::get('/transaksi/item/note/{id}/delete', [ItemNoteController::class, 'delete']);
    Route::get('/component/note/{item_transaksi_id}', [ItemNoteController::class, 'list']);

    //Transaksi
    // Route::get('/transaksi', [PageController::class, 'transaksi'])->name('transaksi')->middleware('permission:Membuka Menu Transaksi');
    Route::get('/transaksi/create', [TransaksiController::class, 'insert']);
    Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'show']);
    Route::get('/transaksi/search', [TransaksiController::class, 'search']);
    Route::get('/transaksi/addItem', [ItemTransaksiController::class, 'addItemToTransaksi']);
    Route::post('/transaksi/update/{id}', [TransaksiController::class, 'update']);
    Route::post('/transaksi/express/{id}', [TransaksiController::class, 'setExpress']);
    Route::post('/transaksi/setrika_only/{id}', [TransaksiController::class, 'setSetrikaOnly']);
    Route::post('/transaksi/penerima', [PenerimaController::class, 'insert']);
    Route::get('/transaksi/cancelled', [PageController::class, 'cancel']);
    Route::get('/transaksi/{transaksi}/cancel', [TransaksiController::class, 'cancelTransaksi']);
    Route::get('/transaksi/{id}/restore', [TransaksiController::class, 'restoreTransaksi']);
    Route::get('/diskon-transaksi/{id}', [DiskonTransaksiController::class, 'find']);
    Route::post('/diskon-transaksi', [DiskonTransaksiController::class, 'insert']);
    Route::get('/diskon-transaksi/{id}/delete', [DiskonTransaksiController::class, 'delete']);
    Route::get('/transaksi/{id}/log', [TransaksiController::class, 'logTransaksi']);
    Route::get('/component/shortTrans/{id}', [TransaksiController::class, 'shortTable']);
    Route::get('/component/shortTrans/{id}/process', [TransaksiController::class, 'shortTableProcess']);
    Route::get('/component/shortTrans/{id}/delivery', [TransaksiController::class, 'shortTableDelivery']);

    // Bucket
    Route::get('/transaksi/bucket', [PageController::class, 'bucket'])->name('transaksi');
    Route::get('/component/transBucket/{id}', [TransaksiController::class, 'tableBucket']);
    // Premium
    Route::get('/transaksi/premium', [PageController::class, 'premium'])->name('transaksi');
    Route::get('/component/transPremium/{id}', [TransaksiController::class, 'tablePremium']);

    // proses cuci & seterika
    Route::get('/proses/cuci', [PageController::class, 'hubCuci']);
    Route::get('/proses/setrika', [PageController::class, 'hubSetrika']);
    //ganti status pencuci & penyetrika
    Route::get('/transaksi/{transaksi}/pencuci', [TransaksiController::class, 'changeStatusCuci']);
    Route::get('/transaksi/{transaksi}/pencuci/done', [TransaksiController::class, 'doneCuci']);
    Route::get('/transaksi/{transaksi}/penyetrika', [TransaksiController::class, 'changeStatusSetrika']);
    Route::get('/transaksi/{transaksi}/penyetrika/done', [TransaksiController::class, 'doneSetrika']);
    //hapus status pencuci & penyetrika
    Route::get('/transaksi/{transaksi}/pencuci/delete', [TransaksiController::class, 'clearStatusCuci']);
    Route::get('/transaksi/{transaksi}/penyetrika/delete', [TransaksiController::class, 'clearStatusSetrika']);
    //Autentikasi Diskon
    Route::post('/transaksi/diskon/autentikasi', [TransaksiController::class, 'authenticationDiskon']);

    //History
    Route::get('/data/pelanggan/{id_pelanggan}/detail', [PelangganController::class, 'detailPelanggan']);
    Route::get('/pelanggan/{id_pelanggan}/history/transaksi', [TransaksiController::class, 'historyPelanggan']);
    Route::get('/pelanggan/{id_pelanggan}/history/saldo', [SaldoController::class, 'historyPelanggan']);

    //Saldo
    Route::get('/transaksi/saldo', [PageController::class, 'saldo']);
    Route::get('/pelanggan/{pelanggan_id}/check-saldo', [SaldoController::class, 'getSaldo']);
    Route::post('/pelanggan/{pelanggan_id}/add-saldo', [SaldoController::class, 'insert']);

    //Pembayaran
    Route::get('/transaksi/pembayaran', [PageController::class, 'pembayaran'])->name('menu_pembayaran');
    Route::get('/transaksi/pembayaran/{pembayaran}', [PembayaranController::class, 'show']);
    Route::post('/transaksi/pembayaran', [PembayaranController::class, 'insert']);
    Route::post('/transaksi/pembayaran-tagihan', [PembayaranController::class, 'bayarTagihan']);;
    Route::post('/transaksi/pembayaran/{pembayaran}', [PembayaranController::class, 'update']);
    Route::get('/transaksi/pembayaran/delete/{pembayaran}', [PembayaranController::class, 'delete']);
    //Inventory
    Route::get('/data/inventory', [PageController::class, 'inventory'])->name('menu-inventory');
    Route::post('/data/inventory/insert', [InventoryController::class, 'insert']);
    Route::post('/data/inventory/update/{inventory}', [InventoryController::class, 'update']);
    Route::get('/data/inventory/delete/{inventory}', [InventoryController::class, 'delete']);
    Route::post('/data/inventory/traffic', [LaporanInventoryController::class, 'insert']);

    //Rewash proses
    Route::get('/proses/rewash', [PageController::class, 'prosesRewash'])->name('menu-rewash');
    Route::post('/proses/rewash/insert', [RewashController::class, 'insert']);
    Route::post('/proses/rewash/update-status/{rewash}', [RewashController::class, 'updateStatus']);
    Route::get('/proses/rewash/delete/{rewash}', [RewashController::class, 'delete']);

    //Packing
    Route::get('/proses/packing', [PageController::class, 'packing']);
    Route::post('/proses/packing', [PackingController::class, 'create']);
    Route::get('/component/packing/{id}', [PackingController::class, 'tablePacking']);

    //Laporan
    Route::get('/laporan/piutang', [LaporanController::class, 'laporanPiutangPelanggan']);
    // Route::get('/laporan/omset', [PageController::class, 'laporanOmset']);
    // Route::get('/laporan/kas_masuk', [PageController::class, 'laporanKasMasuk']);
    // Route::get('/laporan/mutasi_deposit', [PageController::class, 'laporanMutasiDepos']);
    // Route::post('/proses/packing', [PackingController::class, 'create']);

});
