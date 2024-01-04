<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SslCommerzPaymentController;
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

Route::get('/', [HomeController::class, 'index']);

Route::get('/home', [HomeController::class, 'redirect'])->middleware('auth', 'verified');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/add_doctor_view', [AdminController::class, 'addview']);

Route::get('/showappointment', [AdminController::class, 'showappointment']);

Route::get('/approved/{id}', [AdminController::class, 'approved']);

Route::get('/canceled/{id}', [AdminController::class, 'canceled']);

Route::get('/showdoctor', [AdminController::class, 'showdoctor']);
Route::get('/showdoctorUser', [AdminController::class, 'showdoctorUser']);


Route::post('/upload_doctor', [AdminController::class, 'upload']);

Route::get('/deletedoctor/{id}', [AdminController::class, 'deletedoctor']);

Route::get('/appoint/{id}', [AdminController::class, 'appoint']);

Route::get('/updatedoctor/{id}', [AdminController::class, 'updatedoctor']);

Route::post('/editdoctor/{id}', [AdminController::class, 'editdoctor']);

Route::get('/emailview/{id}', [AdminController::class, 'emailview']);

Route::post('/sendemail/{id}', [AdminController::class, 'sendemail']);

Route::post('/appoinment', [HomeController::class, 'appoinment']);

Route::get('/myappoinment', [HomeController::class, 'myappoinment']);

Route::get('/cancel_appoint/{id}', [HomeController::class, 'cancel_appoint']);

// doctor panel presciption

Route::get('/showDoctorappoinment', [HomeController::class, 'showDoctorappoinment']);
Route::get('/statusview/{id}', [HomeController::class, 'statusview']);
Route::get('/presciption/{id}', [HomeController::class, 'presciption']);
Route::post('/presciption', [HomeController::class, 'presciptionSend']);

Route::get('/histroy/{name}', [HomeController::class, 'histroy']);
Route::get('/report', [HomeController::class, 'report']);

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

// Route::get('/success', function () {
//     return 'Success Page';
// });