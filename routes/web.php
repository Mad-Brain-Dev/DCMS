<?php

use App\Http\Controllers\Admin\Profile\UserProfileController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Cases\CaseController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Debtor\DebtorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect()->route('login');
});
Route::get('/execute-command', function () {
//    return redirect()->route('login');
//    Artisan::call('storage:link');
    Artisan::call('migrate:fresh --seed');
    dd('All commands : executed successfully');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//single case show to client
Route::get('/case/show/to/client', [CaseController::class, 'casesShowtoClient'])->name('case.show.client');
//case show to client in datatable
Route::get('/case/show/to/perticular/client', [CaseController::class, 'casesForPerticularClient'])->name('case.show.perticual.client');


//all routes for admin
Route::prefix('admin')->as('admin.')->group(function () {
    // User
    Route::resource('users', UsersController::class);
    //Client
    Route::resource('clients', ClientController::class);
    //Debtor
    Route::resource('debtors', DebtorController::class);
    //Role
    Route::resource('roles', RoleController::class);
    //Role
    Route::resource('cases', CaseController::class);
    //Download Case Pdf
    Route::get('download/case/pdf/file/{id}', [CaseController::class, 'downloadCasePdf'])->name('download.case.pdf');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.info');
    Route::post('/avatar/update', [UserProfileController::class, 'avatarUpdate'])->name('avatar.update');
    Route::put('/profile/update/{id}', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/pass/update/', [UserProfileController::class, 'updatePassword'])->name('update.password');

});



//all routes for manager
Route::prefix('manager')->as('manager.')->group(function () {

});

//all routes for HR
Route::prefix('hr')->as('hr.')->group(function () {

});

//all routes for Employee
Route::prefix('employee')->as('employee.')->group(function () {

});


