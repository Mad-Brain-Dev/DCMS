<?php

use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Profile\UserProfileController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Cases\CaseController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Debtor\DebtorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\ClientMail;
use App\Models\Client;

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
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');
    dd('All commands : executed successfully');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//show printable case agreement with details
Route::get('/printable/case/agreement/{id}', [CaseController::class, 'printableCaseAgreement'])->name('printable.case.agreement');

//show printable case letter with details
Route::get('/printable/letter/{id}', [CaseController::class, 'printableLetter'])->name('printable.case.letter');
//show printable client agreement with details
Route::get('/printable/client/agreement/{id}', [ClientController::class, 'printableClientAgreement'])->name('printable.client.agreement');
//single case show to client
Route::get('/case/show/to/client', [CaseController::class, 'casesShowtoClient'])->name('case.show.client');
//case show to client in datatable
Route::get('/case/show/to/perticular/client', [CaseController::class, 'casesForPerticularClient'])->name('case.show.perticual.client');
// Date of agreement depend on client
Route::get('/date/of/agreement/for/case', [CaseController::class, 'dateOfAgreementForCase'])->name('date.of.agreement');
// create updates for case
Route::post('/generel/update/create/for/case', [CaseController::class, 'generalCaseCreate'])->name('general.case.create');

Route::post('/field/visit/create/for/case', [CaseController::class, 'fieldVisitCaseCreate'])->name('field.visit.create');

//case finding by status route
Route::get('/get/cases/status/{status}', [CaseController::class, 'getCasebyStatus'])->name('get.case.status');
//case create
Route::post('/create/case/for/client', [CaseController::class, 'createCase'])->name('create.case');
//client create
Route::post('/create/client/for/case', [ClientController::class, 'createClient'])->name('create.client');





// show field visit update in modal
Route::get('/show/single/field/visit/update/', [CaseController::class, 'showSingleFieldVisitUpdate'])->name('single.field.vist.update');

// show general case update in modal
Route::get('/show/general/case/update/', [CaseController::class, 'showGeneralCaseUpdate'])->name('single.general.case.update');

// show correspondence case update in modal
Route::get('/show/correspondence/case/update/', [CaseController::class, 'showCorrespondenceUpdate'])->name('single.correspondence.case.update');

// show miscellaneous case update in modal
Route::get('/show/miscellaneous/case/update/', [CaseController::class, 'showMiscellaneousUpdate'])->name('single.miscellaneous.case.update');
//search client
Route::get('admin/client/search/', [CaseController::class, 'clientSearch'])->name('client.search');
//search case
Route::get('admin/case/search/', [CaseController::class, 'caseSearch'])->name('case.search');

//get the perticular client after search
Route::post('search/for/client/', [CaseController::class, 'searchForClient'])->name('search.for.client');

//get the perticular case after search
Route::post('search/for/case/', [CaseController::class, 'searchForCase'])->name('search.for.case');







// view fv update
Route::get('/show/field/visit/update/{id}', [CaseController::class, 'viewFieldVisitUpdate'])->name('show.field.visit.update');
// view gn case update
Route::get('/show/general/case/update/{id}', [CaseController::class, 'viewGeneralCaseUpdate'])->name('view.general.case.update');
// view cr case update
Route::get('/show/correspondence/case/update/{id}', [CaseController::class, 'viewCorrespondenceUpdate'])->name('view.correspondence.update');
// view ms case update
Route::get('/show/miscellaneous/case/update/{id}', [CaseController::class, 'viewMiscellaneousUpdate'])->name('view.miscellaneous.update');

// update admin fee
Route::put('client/admin/fee/update/{id}', [ClientController::class, 'updateAdminFee'])->name('admin.fee.update');
//update total amount balance
Route::put('update/total/amount/balance/{id}', [CaseController::class, 'updateTotalAmountBalance'])->name('update.total.amount.balance');

//all routes for admin
Route::prefix('admin')->as('admin.')->group(function () {
    // User
    Route::resource('users', UsersController::class);
    // Employee
    Route::resource('employees', EmployeeController::class);
    //Client
    Route::resource('clients', ClientController::class);
    //Debtor
    Route::resource('debtors', DebtorController::class);
    //Role
    Route::resource('roles', RoleController::class);
    //cases
    Route::resource('cases', CaseController::class);
    //Reports

    //Download Case Pdf
    Route::get('download/case/pdf/file/{id}', [CaseController::class, 'downloadCasePdf'])->name('download.case.pdf');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.info');
    Route::post('/avatar/update', [UserProfileController::class, 'avatarUpdate'])->name('avatar.update');
    Route::put('/profile/update/{id}', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/pass/update/', [UserProfileController::class, 'updatePassword'])->name('update.password');

    Route::get('reports/index', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/status/case-doughnut-data', [ReportController::class, 'saleDoughnutChartData'])->name('reports.saleDoughnutChartData');
    Route::get('reports/chart/admin-fee-line-chart', [ReportController::class, 'adminFeeLineChartData'])->name('reports.adminFeeLineChartData');
    Route::get('reports/chart/installment-bar-chart', [ReportController::class, 'installmentBarChartData'])->name('reports.installmentBarChartData');
    Route::get('reports/table/debtor-balance-data', [ReportController::class, 'debtorBalanceTableData'])->name('reports.debtorBalanceTableData');

});



