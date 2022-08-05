<?php

use App\Marketing;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\dpp\AboutController;
use App\Http\Controllers\dpc\{AnggotaController, PenghubungController, PenghubungKecamatanController};
use App\Http\Controllers\dpd\PenghubungController as PenghubungdpdController;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kepengurusan;
use App\Kantor;
use App\DetailUsers;

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
    return view('auth.login');
});
Route::get('/termscondition', function () {
    return view('termcondition');
});
Route::get('/privacy_policy', function () {
    return view('privacy_policy');
});

Route::get('/mac', function () {
    $macAddr = substr(exec('getmac'), 0, 17);
});


// Route::get('test', function () {
//     $kantor = Kabupaten::selectRaw("
//                 *
//             ")
//             // kantor.no_sk AS file_sk,
//             //     kantor.domisili,
//             //     kantor.surat_keterangan_kantor AS skk,
//             //     kantor.rekening_bank,
//             //     kantor.id_kantor,
//             //     kantor.alamat,
//             //     kantor.status_kantor,
//             //     kantor.tgl_selesai,
//             //     kantor.nomor_rekening_bank,
//             //     kabupatens.name,
//             //     kabupatens.id_kab,
//             //     kepengurusan.no_sk,
//             //     dpc.jml,
//             //     kab.jml_kab,
//             //     kp.jml_pengurus,
//             //     kpp.jml_perempuan,
//             //     ang.jml_ang,
//             //     provinsis.name as prov,
//             //     ang.status
//             ->leftJoin(DB::raw('(SELECT DISTINCT * FROM `kantor` GROUP BY `id_daerah`) kantor'), function ($join) {
//                 $join->where('kantor.deleted_at', null);
//                 $join->where('kantor.id_tipe_daerah', 3);
//                 $join->on('kantor.id_daerah', '=', 'kabupatens.id_kab');
//             })
//             ->leftJoin('kepengurusan', function ($join) {
//                 $join->where('kepengurusan.jabatan', '=', 3001);
//                 $join->where('kepengurusan.deleted_at', null);
//                 $join->on('kabupatens.id_kab', '=', 'kepengurusan.id_daerah');
//             })
//             ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'kabupatens.id_prov');

//         // JOIN (SELECT DISTINCT id_daerah, deleted_at FROM kantor ) as kantor ON kantor.id_daerah = kecamatans.id_kec AND kantor.deleted_at IS NULL
//         $jTable1 = DB::raw("(
//             SELECT DISTINCT
//                 COUNT(id) AS jml,
//                 kecamatans.id_kab
//             FROM
//                 kecamatans
//             LEFT JOIN (
//                 SELECT DISTINCT
//                     *
//                 FROM
//                     kepengurusan
//                 WHERE
//                     kepengurusan.deleted_at IS NULL AND kepengurusan.jabatan = 4001
//                 GROUP BY
//                     kepengurusan.id_daerah
//             ) kepengurusan ON kepengurusan.id_daerah = kecamatans.id_kec AND jabatan = 4001
//             WHERE
//                 kepengurusan.no_sk IS NOT NULL
//             GROUP BY
//                 kecamatans.id_kab
//             ) as dpc");

//         $kantor->leftJoin($jTable1, 'dpc.id_kab', '=', 'kabupatens.id_kab');
//         $jTable2 = DB::raw("(
//                 SELECT DISTINCT COUNT(id) as jml_kab, id_kab FROM kecamatans GROUP BY kecamatans.id_kab
//             ) as kab");
//         $kantor->leftJoin($jTable2, 'kab.id_kab', '=', 'kabupatens.id_kab');

//         $jTable3 = DB::raw("(SELECT DISTINCT COUNT(nik) as jml_pengurus, id_daerah FROM kepengurusan WHERE deleted_at IS NULL GROUP BY id_daerah ) as kp");
//         $kantor->leftJoin($jTable3, 'kp.id_daerah', '=', 'kabupatens.id_kab');

//         $jTable4 = DB::raw("(
//             SELECT DISTINCT
//                 SUM(
//                     CASE
//                         WHEN SUBSTRING(nik, 7, 2) > 40 THEN 1 ELSE 0
//                     END
//                 ) as jml_perempuan,
//                 id_daerah
//             FROM
//                 kepengurusan
//             WHERE
//                 deleted_at IS NULL
//             GROUP BY
//                 id_daerah
//         ) as kpp");

//         $kantor->leftJoin($jTable4, 'kpp.id_daerah', '=', 'kabupatens.id_kab');

//         $jTable5 = DB::raw("(
//             SELECT DISTINCT
//                 SUM(
//                     CASE
//                         WHEN status_kta = 1 THEN 1
//                         ELSE 0
//                     END
//                 ) as jml_ang,
//                 CASE
//                     WHEN created_at >= CURRENT_DATE - INTERVAL 9 DAY AND created_at  < CURRENT_DATE + INTERVAL 1 DAY THEN 'warning'
//                     WHEN created_at >= CURRENT_DATE - INTERVAL 19 DAY AND created_at  < CURRENT_DATE + INTERVAL 1 DAY THEN 'danger'
//                     ELSE 'none'
//                 END AS status,
//                 kabupaten_domisili
//             FROM
//                 detail_users
//             WHERE
//                 deleted_at IS NULL
//             GROUP BY
//                 kabupaten_domisili
//         ) as ang");

//         $kantor->leftJoin($jTable5, 'ang.kabupaten_domisili', '=', 'kabupatens.id_kab');
//         $kantor->where('kabupatens.id_kab', 8172);
//         dd($kantor->get());
// });
Route::get('dpc/member/coba',  [AnggotaController::class, 'coba'])->name('member.coba');
// Route::get('dpc/penghubung/getindex', [PenghubungController::class, 'getindex'])->name('penghubung.getindex');
// Route::get('dpd/penghubung/getindex', [PenghubungdpdController::class, 'getindex'])->name('penghubung.getindex');
// Route::get('dpc/kecamatan/{id}/penghubungs/getindex', [PenghubungKecamatanController::class, 'getindex'])->name('penghubungs.getindex');

// Route::get('/dpp/about/{id}', [AboutController::class, 'show']);
// Route::get('/dpc/member/{id}/cetak', [AnggotaController::class, 'cetak']);

Auth::routes();

Route::get('forget-password', 'ChangePasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'ChangePasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'ChangePasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'ChangePasswordController@submitResetPasswordForm')->name('reset.password.post');


Route::middleware('auth')->group(function () {

    Route::middleware('mac_addr')->group(function () {

        // Route::middleware('mac')->group(function () {
        // Route Dashboard
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/profile', 'DashboardController@profile')->name('profile');
        Route::get('/profile/edit', 'DashboardController@edit')->name('edit.profile');
        Route::post('/profile/update', 'DashboardController@update')->name('update.profile');

        Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
            // Route Permissions
            Route::resource('permissions', 'PermissionController');

            // Route Roles
            Route::resource('roles', 'RolesController');

            // Route Master User
            Route::resource('users', 'UserController');

            // Route Master satuan

            Route::resource('satuan', 'SatuanController');
            Route::patch('admin/satuan/{satuan:id}', 'SatuanController@update')->name('satuan.update');
            // Route::patch('satuan/{satuan}/update', 'SatuanController@update');


            Route::resource('unit', 'UnitController');


            Route::get('pembatalans/{id}', 'PembatalanUnitController@update')->name('pembatalans.update');
            Route::resource('pembatalans', 'PembatalanUnitController');


            Route::resource('warehouse', 'WarehouseController');


            //ajaxcontroller
            Route::get('ajax/ajax_rekap_reinburst', 'AjaxController@ajax_rekap_reinburst');

            Route::get('ajax/ajax_pembatalan', 'AjaxController@ajax_pembatalan');
            Route::get('ajax/ajax_listpurchase', 'AjaxController@ajax_listpurchase');

            Route::get('ajax/ajax_gaji', 'AjaxController@ajax_gaji');

            Route::get('ajax/ajax_acc_reinburst', 'AjaxController@ajax_acc_reinburst');

            Route::get('ajax/ajax_reinburst', 'AjaxController@ajax_reinburst');


            Route::get('ajax/ajax_customer', 'AjaxController@ajax_customer');


            Route::get('ajax/ajax_pengajuan', 'AjaxController@ajax_pengajuan');


            Route::get('ajax/ajax_penerimaan', 'AjaxController@ajax_penerimaan');
            Route::get('ajax/ajax_faktur', 'AjaxController@ajax_faktur');


            Route::get('ajax/ajax_purchase', 'AjaxController@ajax_purchase');
            Route::get('ajax/ajax_product', 'AjaxController@ajax_product');

            Route::resource('supplier', 'SupplierController');
            Route::get('/where/product', 'PurchaseController@WhereProduct');
            Route::get('/where/service', 'PurchaseController@WhereService');
            Route::resource('purchase', 'PurchaseController');


            Route::resource('transfer', 'TransferStokController');
            Route::get('/transfer/where/product', 'TransferStokController@WhereProduct');

            // Route Master Reinburst
            Route::resource('reinburst', 'ReinburstController');

            // Route Master Barang
            Route::resource('product', 'BarangController');
            // Route Master Kategori Barang

            Route::resource('kategori', 'KategoriController');

            // Route Master Service
            Route::resource('service', 'ServiceController');

            // Route Harga Barang Cabang
            Route::get('price-service/{cabang:id}/create', 'HargaBarangController@create');
            Route::get('price-service/{hargaProdukCabang:id}/edit', 'HargaBarangController@edit');
            Route::get('price-product/{cabang:id}/create', 'HargaBarangController@create');
            Route::get('price-product/{hargaProdukCabang:id}/edit', 'HargaBarangController@edit');

            Route::post('price/store', 'HargaBarangController@store');
            Route::patch('price/{hargaProdukCabang:id}/update', 'HargaBarangController@update');
            Route::delete('price/{hargaProdukCabang:id}/destroy', 'HargaBarangController@destroy');

            // Route Master Patient
            Route::get('pasien/simbol/{warna}', 'PatientController@simbol')->name('pasien.simbol');
            Route::get('pasien/{customer:id}/odontogram', 'PatientController@odontogram')->name('pasien.odontogram');
            Route::get('pasien/{customer:id}/cekfisik', 'PatientController@cekfisik')->name('pasien.cekfisik');
            Route::get('pasien/cetakodontogram/{customer:id}', 'PatientController@cetakodontogram')->name('pasien.cetakodonto');
            Route::get('pasien/cetakriwayat/{customer:id}', 'PatientController@cetakriwayat')->name('pasien.cetakriwayat');
            Route::get('pasien/{customer:id}/history', 'PatientController@history')->name('pasien.history');
            Route::get('pasien/{customer:id}/image', 'PatientController@image')->name('pasien.image');
            Route::post('pasien/{customer:id}/storefisik', 'PatientController@storefisik')->name('pasien.storefisik');
            Route::get('pasien/ajax', 'PatientController@ajaxPasien');
            Route::resource('pasien', 'PatientController');


            // Route Master Payments
            Route::resource('payments', 'PaymentController');

            // Route Master simbol
            Route::resource('simbol', 'SimbolOdontogramController');

            // Route Master Status Pasien
            Route::resource('status', 'StatusPasienController');

            // Route Master Voucher
            Route::post('voucher/kode', 'VoucherController@kode')->name("voucher.kode");
            Route::resource('voucher', 'VoucherController');

            // Route Master Komisi
            Route::resource('komisi', 'KomisiController');

            // Route Master 

            Route::get('dokter/resign/{id}', 'DokterController@resign')->name('dokter.resign');
            Route::resource('dokter', 'DokterController');
            // Route Master Ruangan
            Route::get('ruangan/{cabang:id}/create', 'RuanganController@create');
            Route::resource('ruangan', 'RuanganController');

            // Route customer

            Route::get('customer/ajax', 'CustomerController@ajax');
            Route::resource('customer', 'CustomerController');

            // Route Report
            Route::get('report/pasien', 'ReportController@pasien')->name('report.pasien');
            Route::post('report/pasien', 'ReportController@pasien')->name('report.pasien');
            // Route::get('report/pasien/export/{cabang:id}', 'ReportController@pasienexport')->name('pasien.export');
            Route::get('report/appoinment', 'ReportController@appoinment')->name('report.appoinment');
            Route::post('report/appointment', 'ReportController@appoinment')->name('report.appointment');
            // Route::get('report/appoinment/export/{cabang:id}', 'ReportController@appoinmentreport')->name('appoinment.export');
            Route::get('report/payment', 'ReportController@payment')->name('report.payment');
            Route::post('report/payment', 'ReportController@payment')->name('report.payment');
            // Route::get('report/payment/export/{payment:id}', 'ReportController@paymentreport')->name('payment.export');
            Route::get('report/komisi', 'ReportController@komisi')->name('report.komisi');
            Route::post('report/komisi', 'ReportController@komisi')->name('report.komisi');
            // Route::get('report/komisi/export/{role:id}', 'ReportController@komisireport')->name('komisi.export');
            Route::get('report/perpindahan/pasien', 'ReportController@perpindahan')->name('report.perpindahan.pasien');
            Route::post('report/perpindahan/pasien', 'ReportController@perpindahan')->name('report.perpindahan.pasien');

            Route::get('report/barang', 'ReportController@barang')->name('report.barang');
            Route::post('report/barang', 'ReportController@barang')->name('report.barang');

            //Route Master Holidays
            Route::resource('holidays', 'HolidaysController');
            Route::get('holidays/datatables', 'HolidaysController@datatables')->name('holidays.datatables');
            //Route Master Attendance
            Route::get('/attendance/edit/{id}/{year}/{month}', 'AttendanceController@AttendanceEditYearMonth')->name('attendance.edit.year.month');
            Route::get('/attendance/reset/{id}/{year}/{month}', 'AttendanceController@AttendanceResetYearMonth')->name('attendance.reset.year.month');
            Route::get('/attendance/update_user/{bulan}/{tahun}', 'AttendanceController@update_user')->name('attendance.update_user');
            Route::get('/attendance/search', 'AttendanceController@search')->name('attendance.search');

            Route::resource('attendance', 'AttendanceController');
            Route::post('attendance/laporan', 'AttendanceController@laporan')->name('attendance.laporan');
            Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
            Route::resource('/setting', 'SettingController');
        });

        Route::prefix('dpp')->namespace('dpp')->as('dpp.')->group(function () {
            Route::get('kta-ktp/cetak/kecamatan/{id}/{id_kec}', 'ShowDataController@kta_ktp_zip')->name('kelurahan.cetak.zip');
            Route::get('list/dpc', 'ShowDataController@list_dpc')->name('list.dpc');

            Route::get('man-kta-ktp/cetak/kecamatan/{id}/{id_kec}', 'ShowDataController@manual_kta_ktp_zip')->name('manual.cetak.zip');

            //Informasi
            Route::resource('informasi', 'InformationController');

            //Log Activity
            Route::resource('log_activity', 'LoginActivityController');

            //Log jabatan

            Route::resource('jabatan', 'JabatanController');


            Route::resource('pekerjaan', 'PekerjaanController');


            Route::resource('about', 'AboutController');


            // Kantor Pusat
            Route::get('settings', 'SettingsController@index')->name('settings.index');
            Route::get('settings/kantor', 'SettingsController@kantor')->name('settings.kantor.index');
            Route::get('settings/kantor/create', 'SettingsController@kantor_create')->name('settings.kantor.create');
            Route::post('settings/kantor', 'SettingsController@kantor_store')->name('settings.kantor.store');
            Route::get('settings/kantor/edit', 'SettingsController@kantor_edit')->name('settings.kantor.edit');
            Route::put('settings/kantor', 'SettingsController@kantor_update')->name('settings.kantor.update');
            Route::get('settings/{id}/domisili', 'SettingsController@domisili')->name('settings.domisili');
            Route::get('settings/{id}/no_sk', 'SettingsController@no_sk')->name('settings.no_sk');
            Route::get('settings/{id}/surat_keterangan', 'SettingsController@surat_keterangan')->name('settings.surat_keterangan');
            Route::get('settings/{id}/rekening_bank', 'SettingsController@rekening_bank')->name('settings.rekening_bank');
            Route::get('settings/{id}/akta_pendirian', 'SettingsController@akta_pendirian')->name('settings.akta_pendirian');

            // Kepengurusan Pusat
            Route::get('settings/kepengurusan', 'SettingsController@kepengurusan_index')->name('settings.kepengurusan.index');
            Route::get('settings/kepengurusan/create', 'SettingsController@kepengurusan_create')->name('settings.kepengurusan.create');
            Route::post('settings/kepengurusan', 'SettingsController@kepengurusan_store')->name('settings.kepengurusan.store');
            Route::get('settings/kepengurusan/{id}', 'SettingsController@kepengurusan_edit')->name('settings.kepengurusan.edit');
            Route::put('settings/kepengurusan/{id}', 'SettingsController@kepengurusan_update')->name('settings.kepengurusan.update');
            Route::delete('settings/kepengurusan/{id}', 'SettingsController@kepengurusan_destroy')->name('settings.kepengurusan.destroy');
            Route::get('/where/settings/kepengurusan/loaddata', 'SettingsController@loaddata');
            Route::get('/where/settings/kepengurusan/searchAnggota', 'SettingsController@searchAnggota');


            // Kepengurusan Provinsi
            Route::resource('provinsi/{id}/kepengurusan', 'KepengurusanProvinsiController');
            Route::get('/where/kepengurusan/loaddata/{id}', 'KepengurusanProvinsiController@loaddata');
            Route::get('/where/kepengurusan/searchAnggota', 'KepengurusanProvinsiController@searchAnggota');


            Route::get('ajax/ajax_kepengurusan', 'AjaxController@ajax_kepengurusan')->name('ajax.kepengurusan');

            Route::get('ajax/ajax_kepengurusan_provinsi', 'AjaxController@ajax_kepengurusan_provinsi')->name('ajax.kepengurusan_provinsi');

            // Kantor Provinsi
            Route::resource('provinsi/{id}/kantor', 'KantorProvinsiController');
            Route::get('provinsi/{id}/domisili', 'KantorProvinsiController@domisili')->name('provinsi.domisili');
            Route::get('provinsi/{id}/no_sk', 'KantorProvinsiController@no_sk')->name('provinsi.no_sk');
            Route::get('provinsi/{id}/surat_keterangan', 'KantorProvinsiController@surat_keterangan')->name('provinsi.surat_keterangan');
            Route::get('provinsi/{id}/rekening_bank', 'KantorProvinsiController@rekening_bank')->name('provinsi.rekening_bank');



            //pembatalan
            Route::resource('pembatalan', 'PembatalanController');
            Route::get('/pembatalan/show/{id}', 'PembatalanController@show')->name('pembatalan.show');
            // Route::get('/pembatalan/update/{id}','PembatalanController@update')->name('pembatalan.update');
            // Route::get('/pembatalan/updateDelete/{id}','PembatalanController@updateDelete')->name('pembatalan.updateDelete');
            Route::get('ajax/ajax_pembatalan', 'AjaxController@ajax_pembatalan');
            Route::get('/where/pembatalan/loaddata', 'PembatalanController@loaddata');
            Route::get('/where/searchAnggota', 'PembatalanController@searchAnggota');

            //Provinsi
            Route::resource('provinsi', 'ProvinsiController');

            // Ajax
            Route::get('ajax/kel', 'AjaxController@getKelurahan');
            Route::get('ajax/kec', 'AjaxController@getKecamatan');
            Route::get('ajax/kab', 'AjaxController@getKabupaten');

            Route::PATCH('provinsi', 'ProvinsiController@update')->name('provinsi.update');
            Route::resource('provinsi/{id}/data', 'ShowDataController');
            Route::get('provinsi/{id}/showprovinsi', 'ShowDataController@showprovinsi')->name('provinsi.showprovinsi');
            Route::get('provinsi/export_hp_parpol/{id}', 'ShowDataController@export_hp_parpol')->name('provinsi.export_hp_parpol');
            Route::get('provinsi/export_parpol/{id}', 'ShowDataController@export_parpol')->name('provinsi.export_parpol');
            Route::get('provinsi/lampiran_hp_parpol/{id}', 'ShowDataController@lampiran_hp_parpol')->name('provinsi.lampiran_hp_parpol');
            Route::get('provinsi/lampiran_parpol/{id}', 'ShowDataController@lampiran_parpol')->name('provinsi.lampiran_parpol');
            Route::get('provinsi/{id}/kecamatan', 'ShowDataController@showkecamatan')->name('provinsi.showkecamatan');
            Route::get('provinsi/{id}/kecamatan/data', 'KecamatanController@showkecamatan');
            Route::get('provinsi/{id}/kelurahan', 'ShowDataController@showkelurahan')->name('provinsi.showkelurahan');
            Route::get('provinsi/{id}/kelurahan/data', 'ShowDataKecamatanController@showKelurahan')->name('provinsi.showKelurahan');
            Route::get('provinsi/cetak/{id}', 'ShowDataController@cetak')->name('provinsi.cetak');
            Route::get('kabupaten/cetak/{id}', 'ShowDataController@cetak')->name('kabupaten.cetak');
            Route::get('kecamatan/cetak/{id}', 'ShowDataController@cetak')->name('kecamatan.cetak');
            Route::get('kecamatan/cetaks/{id}', 'ShowDataController@cetaks')->name('kecamatan.cetaks');
            Route::get('kelurahan/cetak/{id}', 'ShowDataController@cetak')->name('kelurahan.cetak');
            Route::get('provinsi/export_kta_n_ktp_folder/{id}', 'ShowDataController@export_kta_n_ktp_folder')->name('exportktaktp');


            Route::get('ajax/ajax_provinsi', 'AjaxController@ajax_provinsi');
            Route::get('/where/anggota/loaddata', 'ProvinsiController@loaddata');
            Route::get('/where/anggota/loaddatauser', 'ProvinsiController@loaddatauser');
            Route::get('/where/anggota/loaddataanggota', 'ProvinsiController@loaddataanggota');
            
            Route::resource('provinsi/{id}/kecamatan/{id_kec}/generated', 'GeneratedController');
            Route::get('provinsi/{id}/kecamatan/{id_kec}/generated/update',  'GeneratedController@show')->name('provinsi.generated.update');
            Route::get('ajax/{id}/ajax_generated', 'GeneratedController@ajax_generated');

            //Kabupaten
            Route::resource('kabupaten', 'KabupatenController');
            Route::get('kabupaten/{id}/create', 'KabupatenController@create')->name('kabupaten.create');
            Route::get('/penerimaan/export/{penerimaan}', 'PenerimaanController@export')->name('penerimaan.export');
            Route::get('ajax/ajax_kabupaten', 'AjaxController@ajax_kabupaten');
            Route::get('kabupaten/{id}/showkabupaten', 'ShowDataController@showkabupaten')->name('kabupaten.showkabupaten');
            Route::get('kabupaten/{id}/showkta', 'KabupatenController@showkta')->name('kabupaten.showkta');
            Route::get('kabupaten/{id}/showkta_hp', 'KabupatenController@showkta_hp')->name('kabupaten.showkta_hp');
            Route::get('kabupaten/{id}/show_hp', 'KabupatenController@show_hp')->name('kabupaten.show_hp');
            Route::get('kabupaten/{id}/show', 'KabupatenController@show')->name('kabupaten.show');
            Route::get('ajax/ajax_anggota', 'AjaxController@ajax_anggota');
            Route::delete('kabupaten/destroy/{id}', 'KabupatenController@destroy')->name('kabupaten.destroy');
            Route::get('kabupaten/export/{id}', 'KabupatenController@export')->name('kabupaten.export');
            Route::get('kabupaten/export_hp/{id}', 'KabupatenController@export_hp')->name('kabupaten.export_hp');




            //kecamatan
            Route::resource('kecamatan', 'KecamatanController');
            Route::get('kecamatan/{id}/create', 'KecamatanController@create')->name('kecamatan.create');
            Route::post('kecamatan/store/{id}', 'KecamatanController@store')->name('kecamatan.store');
            Route::get('kecamatan/{id}/showkecamatan', 'KecamatanController@showkecamatan')->name('kecamatan.showkecamatan');
            Route::get('kecamatan/export_hp_parpol/{id}', 'KecamatanController@export_hp')->name('kecamatan.export_hp_parpol');
            Route::get('kecamatan/export_parpol/{id}', 'KecamatanController@export')->name('kecamatan.export_parpol');
            Route::get('ajax/ajax_kecamatan', 'AjaxController@ajax_kecamatan');
            Route::resource('kecamatan/{id}/data', 'ShowDataKecamatanController');
            Route::get('kecamatan/{id}/showKelurahan', 'ShowDataKecamatanController@showKelurahan')->name('kecamatan.showKelurahan');

            ///kepengurusan kecamatan
            Route::resource('kecamatan/{id}/kepengurusan', 'KepengurusanKecamatanController');
            Route::get('kecamatan/{id}/kepengurusan/pengurus_excel', 'KepengurusanKecamatanController@show');
            Route::get('ajax/ajax_kepengurusan_kecamatan', 'AjaxController@ajax_kepengurusan_kecamatan')->name('ajax.ajax_kepengurusan_kecamatan');

            //kantor kecamatan
            Route::resource('kecamatan/{id}/kantor', 'KantorKecamatanController');
            Route::get('kecamatan/{id}/domisili', 'KantorKecamatanController@domisili')->name('kecamatan.domisili');
            Route::get('kecamatan/{id}/no_sk', 'KantorKecamatanController@no_sk')->name('kecamatan.no_sk');




            // Kelurahan
            Route::resource('kecamatan/{id}/kelurahan', 'KelurahanController');
            Route::resource('exports', 'ExportController');
            Route::get('/exports/download/{id}', 'ExportController@export')->name('exports.download');
            Route::post('/exports', 'ExportController@store')->name('exports.store');

            //settings
            Route::resource('settings', 'SettingsController');

            //user
            Route::resource('user', 'UserController');
            Route::get('user/{id}/download', 'UserController@download')->name('user.download');
            Route::get('ajax/kel', 'UserController@getKelurahan');
            Route::get('ajax/kec', 'UserController@getKecamatan');
            Route::get('ajax/kab', 'UserController@getKabupaten');



            Route::resource('listuser', 'ListUserController');
            Route::get('ajax/ajax_user', 'AjaxController@ajax_user');


            //article
            Route::resource('kategori', 'ArticleCategoryController');

            // Download ZIP Kabupaten
            Route::get('kabupaten/zip/{id}', 'ProvinsiController@zip_kta_ktp')->name('dpp.kabupaten.zip');
            Route::get('kecamatan/zip/{id}', 'ShowDataController@zip_kta_ktp')->name('dpp.kecamatan.zip');
            Route::get('kabupaten/zip/showkta/{id}', 'ShowDataController@showkta')->name('dpp.kabupaten.zip.showkta');

            // Rekap Kepengurusan
            Route::get('rekap/dpd', 'ProvinsiController@rekap_dpd')->name('rekap.dpd');
            Route::get('rekap/dpc', 'ProvinsiController@rekap_dpc')->name('rekap.dpc.single');
            Route::get('rekap/dpc/{id}', 'ProvinsiController@rekap_dpc')->name('rekap.dpc');
            Route::get('rekap/dpc/{id}/{type}', 'ProvinsiController@rekap_dpc')->name('rekap.dpc.type');
            Route::get('rekap/pac', 'ProvinsiController@rekap_pac')->name('rekap.pac.single');
            Route::get('rekap/pac/{id}/{type}', 'ProvinsiController@rekap_pac')->name('rekap.pac.type');
            Route::get('rekap/pac/{id}', 'ProvinsiController@rekap_pac')->name('rekap.pac');

            // Download File Rekap
            Route::get('download/sk/{id}', 'ProvinsiController@download_sk')->name('download.sk');
            Route::get('download/domisili/{id}', 'ProvinsiController@download_domisili')->name('download.domisili');
            Route::get('download/skk/{id}', 'ProvinsiController@download_ket_kantor')->name('download.skk');
            Route::get('download/rek/{id}', 'ProvinsiController@download_rek_bank')->name('download.rekening_bank');
            Route::get('download/all/{id}', 'ProvinsiController@download_rekap_all')->name('download.all');
        });
        Route::prefix('dpd')->namespace('dpd')->as('dpd.')->group(function () {
            Route::get('ajax/kel', 'AnggotaController@getKelurahan');
            Route::get('ajax/kec', 'AnggotaController@getKecamatan');
            Route::get('ajax/kab', 'AnggotaController@getKabupaten');

            //Informasi
            Route::resource('informasi', 'InformationController');

            //Log Activity
            Route::resource('log_activity', 'LoginActivityController');

            //Provinsi
            Route::resource('provinsi', 'ProvinsiController');
            Route::get('ajax/ajax_provinsi', 'AjaxController@ajax_provinsi');

            // Kantor
            Route::resource('kabupaten/{id}/kantor', 'KantorKabupatenController');
            Route::get('kabupaten/{id}/domisili', 'KantorKabupatenController@domisili')->name('kabupaten.domisili');
            Route::get('kabupaten/{id}/no_sk', 'KantorKabupatenController@no_sk')->name('kabupaten.no_sk');
            Route::get('kabupaten/{id}/surat_keterangan', 'KantorKabupatenController@surat_keterangan')->name('kabupaten.surat_keterangan');
            Route::get('kabupaten/{id}/rekening_bank', 'KantorKabupatenController@rekening_bank')->name('kabupaten.rekening_bank');

            Route::resource('listuser', 'ListUserController');

            Route::get('listuser/{id}/download', 'ListUserController@download')->name('listuser.download');
            Route::post('listuser/having', 'ListUserController@having')->name('listuser.having');
            Route::get('/where/listuser/loaddata', 'ListUserController@loaddata');
            Route::get('/where/listuser/searchAnggota', 'ListUserController@searchAnggota');
            Route::get('ajax/ajax_user', 'AjaxController@ajax_user');

            // Kepengurusan
            Route::resource('kabupaten/{id}/kepengurusan', 'KepengurusanKabupatenController');
            Route::get('/where/kepengurusan/loaddata/{id}', 'KepengurusanKabupatenController@loaddata');
            Route::get('/where/kepengurusan/searchAnggota', 'KepengurusanKabupatenController@searchAnggota');

            Route::get('ajax/ajax_kepengurusan_kabupaten', 'AjaxController@ajax_kepengurusan_kabupaten');


            //Kabupaten
            Route::resource('kabupaten', 'KabupatenController');
            Route::get('/penerimaan/export/{penerimaan}', 'PenerimaanController@export')->name('penerimaan.export');
            Route::get('ajax/ajax_kabupaten', 'AjaxController@ajax_kabupaten');


            //anggota
            Route::resource('member', 'AnggotaController');
            Route::get('member/{id}/download', 'AnggotaController@download')->name('member.download');
            Route::get('member/{id}/cetak', 'AnggotaController@cetak')->name('member.cetak');
            Route::get('member/{id}/provinsi_export', 'AnggotaController@provinsi_export')->name('member.provinsi_export');

            Route::get('ajax/ajax_anggota', 'AjaxController@ajax_anggota');

            //Kelurahan
            Route::resource('kelurahan', 'KelurahanController');
            Route::get('ajax/ajax_kelurahan', 'AjaxController@ajax_kelurahan');

            // Route::get('kabupaten\anggota\{id}', 'KabupatenController');
            Route::get('kabupaten/export/{id}', 'KabupatenController@export')->name('kabupaten.export');

            //kecamatan
            Route::resource('kecamatan', 'KecamatanController');
            Route::get('ajax/ajax_kecamatan', 'AjaxController@ajax_kecamatan');

            Route::resource('pengurus', 'PengurusController');
            Route::get('ajax/ajax_pengurus', 'AjaxController@ajax_pengurus');
            Route::get('pengurus/{id}/show', 'PengurusController@show');

            //user
            Route::resource('user', 'UserController');
            Route::get('ajax/ajax_user', 'AjaxController@ajax_user');


            //article
            Route::resource('kategori', 'ArticleCategoryController');


            Route::resource('pembatalan', 'PembatalanController');
            Route::get('/pembatalan/update/{id}', 'PembatalanController@update')->name('pembatalan.update');
            Route::get('/pembatalan/updateDelete/{id}', 'PembatalanController@updateDelete')->name('pembatalan.updateDelete');
            Route::post('pembatalan/updateacc', 'PembatalanController@updateacc')->name('pembatalan.updateacc');
            Route::post('pembatalan/updatefail', 'PembatalanController@updatefail')->name('pembatalan.updatefail');
            Route::get('/where/pembatalan/loaddata', 'PembatalanController@loaddata');
            Route::get('/where/searchAnggota', 'PembatalanController@searchAnggota');


            Route::get('ajax/ajax_restore', 'AjaxController@ajax_restore');
            Route::resource('restore', 'RestoreController');
            Route::post('restore/updateaktif', 'RestoreController@updateaktif')->name('restore.updateaktif');
            Route::post('restore/updatenonaktif', 'RestoreController@updatenonaktif')->name('restore.updatenonaktif');
            Route::get('restore/destroy/{restore}', 'RestoreController@destroy')->name('restore.destroy');


            Route::get('ajax/ajax_repair', 'AjaxController@ajax_repair');
            Route::resource('repair', 'RepairController');

            Route::get('ajax/ajax_acc_anggota', 'AjaxController@ajax_acc_anggota');
            Route::get('ajax/ajax_pembatalan', 'AjaxController@ajax_pembatalan');

            Route::resource('pending', 'PendingAnggotaController');
            Route::get('pending/edit/{pending}', 'PendingAnggotaController@edit')->name('pending.edit');
            Route::post('pending/updateaktif', 'PendingAnggotaController@updateaktif')->name('pending.updateaktif');
            Route::post('pending/editnonaktif', 'PendingAnggotaController@editnonaktif')->name('pending.editnonaktif');
            Route::post('pending/updatenonaktif', 'PendingAnggotaController@updatenonaktif')->name('pending.updatenonaktif');
            //Log Activity

            //petugas penghubung
            Route::resource('/penghubung', 'PenghubungController');

            Route::get('ajax/kantor/kel', 'KantorKabupatenController@getKelurahan');
            Route::get('ajax/kantor/kec', 'KantorKabupatenController@getKecamatan');
            Route::get('ajax/kantor/kab', 'KantorKabupatenController@getKabupaten');


            Route::get('/wheress/kepengurusan/loaddata/{id}', 'PenghubungController@loadData');
            Route::get('/wheress/kepengurusan/searchAnggota', 'PenghubungController@searchAnggota');
            Route::get('ajax/ajax_penghubung', 'AjaxController@ajax_penghubung');

            Route::get('rekap/dpc', 'ProvinsiController@rekap_dpc')->name('rekap.dpc');
            Route::get('rekap/pac', 'ProvinsiController@rekap_pac')->name('rekap.pac.single');
            Route::get('rekap/pac/{id}/{type}', 'ProvinsiController@rekap_pac')->name('rekap.pac.type');
            Route::get('rekap/pac/{id}', 'ProvinsiController@rekap_pac')->name('rekap.pac');

            // Download File Rekap
            Route::get('download/sk/{id}', 'ProvinsiController@download_sk')->name('download.sk');
            Route::get('download/domisili/{id}', 'ProvinsiController@download_domisili')->name('download.domisili');
            Route::get('download/skk/{id}', 'ProvinsiController@download_ket_kantor')->name('download.skk');
            Route::get('download/rek/{id}', 'ProvinsiController@download_rek_bank')->name('download.rekening_bank');
            Route::get('download/all/{id}', 'ProvinsiController@download_rekap_all')->name('download.all');
        });
        Route::prefix('dpc')->namespace('dpc')->as('dpc.')->group(function () {
            Route::resource('informasi', 'InformationController');

            Route::get('ajax/member/kel', 'AnggotaController@getKelurahan');
            Route::get('ajax/member/kec', 'AnggotaController@getKecamatan');
            Route::get('ajax/member/kab', 'AnggotaController@getKabupaten');

            Route::resource('listingKTP', 'ListingKTPController');
            Route::get('ajax/ajax_listingKTP', 'ListingKTPController@ajax_listingKTP');

            Route::resource('member', 'AnggotaController');
            Route::get('anggota/index',  'AnggotaController@index')->name('member.index');
            Route::get('anggota/sdh_transfer',  'AnggotaController@sdh_transfer')->name('member.sdh_transfer');
            Route::get('anggota/tdk_memenuhi',  'AnggotaController@tdk_memenuhi')->name('member.tdk_memenuhi');
            Route::get('anggota/hasil_perbaikan',  'AnggotaController@hasil_perbaikan')->name('member.hasil_perbaikan');
            Route::get('anggota/cetak_kta',  'AnggotaController@cetak_kta')->name('member.cetak_kta');
            Route::get('anggota/kta_depan/{id}',  'AnggotaController@getKtaDepan');
            Route::get('anggota/docx',  'AnggotaController@down_docx')->name('member.sdh_transfer.docx');
            Route::get('anggota/coba',  'AnggotaController@down_coba')->name('member.sdh_transfer.coba');
            
            Route::get('kabupaten/showMember', 'AnggotaController@showMember')->name('kabupaten.sdh_transfer.showMember');

            Route::post('member/transfer', 'AnggotaController@transfer')->name('member.transfer');
            Route::get('member/{id}/download', 'AnggotaController@download')->name('member.download');
            Route::get('member/{id}/cetak', 'AnggotaController@cetak')->name('member.cetak');
            Route::get('member/{id}/cetak_background', 'AnggotaController@cetak_background')->name('member.cetak_background');

            Route::get('import/anggota', 'AnggotaController@import_anggota')->name('import.anggota');
            Route::get('ajax/import/anggota', 'AnggotaController@ajax_import_anggota')->name('ajax.import.anggota');

            Route::get('member/{id}/show', 'AnggotaController@show')->name('member.show');
            Route::get('kabupaten/{id}/updatekpu', 'KabupatenController@updatekpu')->name('kabupaten.updatekpu');
            Route::get('kabupaten/{id}/updateditolak', 'KabupatenController@updateditolak')->name('kabupaten.updateditolak');
            Route::get('kabupaten/showmember', 'KabupatenController@showmember')->name('kabupaten.showmember');
            Route::post('kabupaten/updatestatus', 'KabupatenController@updatestatus')->name('kabupaten.updatestatus');
            Route::post('kabupaten/updatenonaktif', 'KabupatenController@updatenonaktif')->name('kabupaten.updatenonaktif');
            Route::post('kabupaten/updatereceived', 'KabupatenController@updatereceived')->name('kabupaten.updatereceived');
            Route::post('kabupaten/updatefail', 'KabupatenController@updatefail')->name('kabupaten.updatefail');
            Route::post('kabupaten/updatehasil', 'KabupatenController@updatehasil')->name('kabupaten.updatehasil');
            Route::get('kabupaten/{id}/showkta', 'AnggotaController@showkta')->name('kabupaten.showkta');
            Route::get('kabupaten/{id}/showkta_hp', 'AnggotaController@showkta_hp')->name('kabupaten.showkta_hp');
            Route::get('kabupaten/{id}/show_hp', 'AnggotaController@show_hp')->name('kabupaten.show_hp');

            Route::get('kabupaten/export_hp_parpol/{id}', 'AnggotaController@export_hp_parpol')->name('kabupaten.export_hp_parpol');
            Route::get('kabupaten/export_parpol/{id}', 'AnggotaController@export_parpol')->name('kabupaten.export_parpol');
            Route::get('kabupaten/lampiran_hp_parpol/{id}', 'AnggotaController@lampiran_hp_parpol')->name('kabupaten.lampiran_hp_parpol');
            Route::get('kabupaten/lampiran_parpol/{id}', 'AnggotaController@lampiran_parpol')->name('kabupaten.lampiran_parpol');
            Route::get('kabupaten/export/{id}', 'AnggotaController@export')->name('kabupaten.export');
            Route::get('kabupaten/export_hp/{id}', 'AnggotaController@export_hp')->name('kabupaten.export_hp');
            Route::get('kabupaten/surat_pernyataan/{id}', 'AnggotaController@surat_pernyataan')->name('kabupaten.surat_pernyataan');
            Route::get('kabupaten/{id}/kabupatenall_export', 'AnggotaController@kabupatenall_export')->name('kabupaten.kabupatenall_export');
            Route::get('kelurahan/{id}/kelurahan_export', 'KelurahanController@export')->name('kelurahan.export');
            Route::get('kecamatan/{id}/kecamatan_export', 'KecamatanController@export')->name('kecamatan.export');



            Route::get('ajax/ajax_anggota', 'AjaxController@ajax_anggota');
            Route::get('import/anggota', 'AnggotaController@import_anggota')->name('import.anggota');
            Route::get('import/edit/anggota/{id}', 'AnggotaController@edit_import')->name('edit.import.anggota');
            Route::post('import/save/anggota/', 'AnggotaController@save_import')->name('import.save');
            Route::get('ajax/import/anggota', 'AnggotaController@ajax_import_anggota')->name('ajax.import.anggota');
            Route::post('ajax/add/import/anggota', 'AnggotaController@ajax_add_import_anggota')->name('ajax.import.anggota');


            Route::resource('listuser', 'ListUserController');
            Route::post('listuser/having', 'ListUserController@having')->name('listuser.having');
            Route::get('/where/listuser/loaddata', 'ListUserController@loaddata');
            Route::get('listuser/{id}/download', 'ListUserController@download')->name('listuser.download');
            Route::get('/where/listuser/searchAnggota', 'ListUserController@searchAnggota');
            Route::get('ajax/ajax_user', 'AjaxController@ajax_user');
            Route::get('ajax/ajax_acc_anggota', 'AjaxController@ajax_acc_anggota');
            Route::get('ajax/ajax_pembatalan', 'AjaxController@ajax_pembatalan');

            Route::resource('pembatalan', 'PembatalanController');
            Route::get('/pembatalan/update/{id}', 'PembatalanController@update')->name('pembatalan.update');
            Route::get('/pembatalan/updateDelete/{id}', 'PembatalanController@updateDelete')->name('pembatalan.updateDelete');
            Route::post('pembatalan/updateacc', 'PembatalanController@updateacc')->name('pembatalan.updateacc');
            Route::post('pembatalan/updatefail', 'PembatalanController@updatefail')->name('pembatalan.updatefail');
            Route::get('/where/pembatalan/load', 'PembatalanController@loaddata');
            Route::get('/where/pembatalan/search', 'PembatalanController@searchAnggota');


            Route::get('ajax/ajax_restore', 'AjaxController@ajax_restore');
            Route::resource('restore', 'RestoreController');
            Route::post('restore/updateaktif', 'RestoreController@updateaktif')->name('restore.updateaktif');
            Route::post('restore/updatenonaktif', 'RestoreController@updatenonaktif')->name('restore.updatenonaktif');
            Route::get('restore/destroy/{restore}', 'RestoreController@destroy')->name('restore.destroy');


            Route::get('ajax/ajax_repair', 'AjaxController@ajax_repair');
            Route::resource('repair', 'RepairController');

            // Route::get('report-member', 'AnggotaController@reportMember')->name('report-member');
            // Route::get('member-verified', 'AnggotaController@indexVerified')->name('member-verified');
            // Route::get('edit-verified', 'AnggotaController@editVerified')->name('edit-verified');
            // Route::put('update-verified', 'AnggotaController@editVerified')->name('update-verified');
            // Route::get('edit-korlap/{id}', 'AnggotaController@editKorlap')->name('edit-korlap');
            // Route::put('update-korlap/{id}', 'AnggotaController@updateKorlap')->name('update-korlap');
            Route::resource('pending', 'PendingAnggotaController');
            Route::get('pending/edit/{pending}', 'PendingAnggotaController@edit')->name('pending.edit');
            Route::post('pending/updateaktif', 'PendingAnggotaController@updateaktif')->name('pending.updateaktif');
            Route::post('pending/editnonaktif', 'PendingAnggotaController@editnonaktif')->name('pending.editnonaktif');
            Route::get('pending/ganti/{id}', 'PendingAnggotaController@ganti')->name('pending.ganti');
            Route::PATCH('pending/restore/{id}', 'PendingAnggotaController@restore')->name('pending.restore');


            Route::post('pending/updatenonaktif', 'PendingAnggotaController@updatenonaktif')->name('pending.updatenonaktif');
            //Log Activity
            Route::resource('log_activity', 'LoginActivityController');

            //Provinsi
            Route::resource('kelurahan', 'KelurahanController');
            Route::get('ajax/ajax_kelurahan', 'AjaxController@ajax_kelurahan');

            //Kabupaten
            Route::resource('kabupaten', 'KabupatenController');
            Route::get('ajax/ajax_kabupaten', 'AjaxController@ajax_kabupaten');
            Route::get('ajax/tdk_memenuhi', 'AjaxController@tdk_memenuhi');
            Route::get('ajax/hasil_perbaikan', 'AjaxController@hasil_perbaikan');
            Route::get('ajax/sdh_transfer', 'AjaxController@sdh_transfer');
            Route::get('ajax/ajax_member', 'AjaxController@ajax_member');

            // Route::get('kabupaten\anggota\{id}', 'KabupatenController');
            // Route::get('kabupaten\download\{id]', 'KabupatenController');

            //kecamatan
            Route::resource('kecamatan', 'KecamatanController');
            Route::get('kecamatan/{id}/kuota', 'KecamatanController@kuota')->name('kecamatana.kuota');
            Route::PATCH('kecamatan', 'KecamatanController@update')->name('kecamatan.update');
            Route::get('ajax/ajax_kecamatan', 'AjaxController@ajax_kecamatan');


            //Provinsi
            Route::resource('provinsi', 'ProvinsiController');

            // Ajax
            Route::get('ajax/kel', 'AjaxController@getKelurahan');
            Route::get('ajax/kec', 'AjaxController@getKecamatan');
            Route::get('ajax/kab', 'AjaxController@getKabupaten');

            Route::PATCH('provinsi', 'ProvinsiController@update')->name('provinsi.update');
            Route::resource('provinsi/{id}/data', 'ShowDataController');
            Route::get('provinsi/{id}/showprovinsi', 'ShowDataController@showprovinsi')->name('provinsi.showprovinsi');
            Route::get('provinsi/export_hp_parpol/{id}', 'ShowDataController@export_hp_parpol')->name('provinsi.export_hp_parpol');
            Route::get('provinsi/export_parpol/{id}', 'ShowDataController@export_parpol')->name('provinsi.export_parpol');
            Route::get('provinsi/lampiran_hp_parpol/{id}', 'ShowDataController@lampiran_hp_parpol')->name('provinsi.lampiran_hp_parpol');
            Route::get('provinsi/lampiran_parpol/{id}', 'ShowDataController@lampiran_parpol')->name('provinsi.lampiran_parpol');
            Route::get('provinsi/{id}/kecamatan', 'ShowDataController@showkecamatan')->name('provinsi.showkecamatan');
            Route::get('provinsi/{id}/kecamatan/data', 'KecamatanController@showkecamatan');
            Route::get('provinsi/{id}/kelurahan', 'ShowDataController@showkelurahan')->name('provinsi.showkelurahan');
            Route::get('provinsi/{id}/kelurahan/data', 'ShowDataKecamatanController@showKelurahan')->name('provinsi.showKelurahan');

            Route::get('ajax/ajax_provinsi', 'AjaxController@ajax_provinsi');
            Route::get('/where/anggota/loaddata', 'ProvinsiController@loaddata');
            Route::get('/where/anggota/loaddatauser', 'ProvinsiController@loaddatauser');
            Route::get('/where/anggota/loaddataanggota', 'ProvinsiController@loaddataanggota');


            //user
            Route::resource('user', 'UserController');

            //pengurus
            Route::resource('pengurus', 'PengurusController');

            //article
            Route::resource('kategori', 'ArticleCategoryController');

            //petugas penghubung
            Route::resource('/penghubung', 'PenghubungController');
            
            //route generated
            Route::resource('kecamatan/{id}/generated', 'GeneratedController');
            Route::get('kecamatan/{id}/generated/update',  'GeneratedController@show')->name('provinsi.generated.update');
            Route::get('ajax/{id}/ajax_generated', 'GeneratedController@ajax_generated');


            Route::get('/wheres/penghubung/loaddata/{id}', 'PenghubungController@loadData');
            Route::get('/wheres/penghubung/searchAnggota', 'PenghubungController@searchAnggota');
            Route::get('ajax/ajax_penghubung', 'AjaxController@ajax_penghubung');

            Route::resource('/kecamatan/{id}/penghubungs', 'PenghubungKecamatanController');

            Route::get('/wheres/kecamatan/penghubung/loaddata/{id}', 'PenghubungKecamatanController@loadData');
            Route::get('/wheres/kecamatan/penghubung/searchAnggota', 'PenghubungKecamatanController@searchAnggota');
            Route::get('ajax/ajax_penghubung_kecamatan/{id}', 'AjaxController@ajax_penghubung_kecamatan');
            Route::resource('exports', 'ExportController');
            Route::get('/exports/download/{id}', 'ExportController@export')->name('exports.download');
            Route::get('/exports/{id}', 'ExportController@store')->name('exports.show');
        });
    });
});
