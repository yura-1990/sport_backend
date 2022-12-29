<?php

use App\Models\Check;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

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
    return view('welcome');
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});

Route::get('/file-download/{id}', function ($id) {
    $getpdf = Check::find($id)->pdf;
    $file=Storage::url($getpdf);
    $headers = ['Content-Type: application/pdf'];
    $fileName = time().'.pdf';
    return response()->download(public_path($file));
});



Route::get('firebase-phone-authentication', [FirebaseController::class, 'index']);

Route::redirect('/{something}', '/');
