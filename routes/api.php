<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\V1\Admin\UserApiController as UserController;
// Route::post('login', 'Api\UserApiController@login');
// Route::post('register', 'Api\UserApiController@register');
// Route::post('daftar', 'Api\UserApiController@daftar'); //reg khusus member

Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();
});

Route::post('login', [UserApiController::class, 'login']);
Route::get('/getkategori',[UserApiController::class,'getkategori']);
Route::get('/getartikel',[UserApiController::class,'getartikel']);
Route::get('/getpenguruspusat',[UserApiController::class,'getPusat']);
Route::get('/gettentang',[UserApiController::class,'getTentang']);
Route::get('/getktakabupaten/{id}',[UserApiController::class,'getPDF']);
Route::get('/getktadepan/{id}',[UserApiController::class,'getKtaDepan']);
Route::get('/nikah',[UserApiController::class, 'nikah']);
Route::get('/pekerjaan',[UserApiController::class,'job']);

//reg khusus member

Route::group(['middleware' => ['jwt.verify'], 'namespace' => 'Api\V1\Admin'], function () {

    Route::post('/updatepass',[UserApiController::class,'updatepass']);
Route::get('/getprovinsi',[UserApiController::class,'getProvinsi']);
   
Route::get('/getanggotakab',[UserApiController::class,'getAnggotaKab']);
    Route::get('/getpenguruskab',[UserApiController::class,'getKab']);
    Route::get('/getprofile',[UserApiController::class,'getAuthenticatedUser']);
    Route::post('/destroy/{id}',[UserApiController::class,'destroy']);
    Route::post('/update/{id}',[UserApiController::class,'update']);
    Route::get('/loadpegawai',[UserApiController::class,'loadpegawai']);
    Route::get('/getPending',[UserApiController::class,'getAnggotaPending']);
    Route::post('/updatepending/{id}',[UserApiController::class,'updatepending']);
    Route::get('/getKantor',[UserApiController::class,'getKantor']);
    Route::get('/detailUser/{id}',[UserApiController::class,'detailUser']);
   
    Route::post('daftar', [UserApiController::class, 'daftar']);
    Route::get('job', [UserApiController::class,'job']);
    Route::get('marital-status', [UserApiController::class,'nikah']);
    Route::get('agama', [UserApiController::class,'agama']);

    Route::get('pob', [UserApiController::class,'getPOB']);
    Route::get('prov', [UserApiController::class,'getProv']);
    Route::get('kab', [UserApiController::class,'getKab']);
    Route::get('kec', [UserApiController::class,'getKec']);
    Route::get('kel', [UserApiController::class,'getKel']);
    
    
    
    Route::get('Getkab', [UserApiController::class,'kab']);
    Route::get('Getprov', [UserApiController::class,'prov']);
    Route::get('Getkec', [UserApiController::class,'kec']);
    Route::get('Getkel', [UserApiController::class,'kel']);
    
    Route::apiResource('permissions', 'PermissionsApiController');

    Route::apiResource('roles', 'RolesApiController');

    Route::apiResource('users', 'UsersApiController');

    Route::apiResource('products', 'ProductsApiController');
    
    Route::apiResource('program', 'ProgramApiController');
    
    Route::apiResource('artikel', 'InformationApiController');
    Route::apiResource('article-category', 'ArticleCategoryApiController');
    Route::apiResource('member', 'MemberApiController');
    Route::apiResource('ro', 'RequestOrderApiController');
    Route::apiResource('slider', 'SliderApiController');
    
});
