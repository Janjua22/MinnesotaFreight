<?php

use Illuminate\Support\Facades\Route;
use \UniSharp\LaravelFilemanager\Lfm;

/* Start Admin Controllers */
use App\Http\Controllers\Site\ContactController as Contact;
use App\Http\Controllers\Site\ApplicationController as DriverApplication;
/* End Admin Controllers */

/* Start Admin Controllers */
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\TruckController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FactoringCompanyController;
use App\Http\Controllers\Admin\LoadPlannerController;
use App\Http\Controllers\Admin\FuelExpenseController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\DeductionCategoryController;
use App\Http\Controllers\Admin\ProfitLossController;
use App\Http\Controllers\Admin\DriverSettlementController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\DriverApplicationController;
use App\Http\Controllers\Admin\TaxFormController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\TrashController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\InvoiceBatchController;
use App\Http\Controllers\Admin\RecurringDeductionController;
use App\Http\Controllers\Admin\StateCityController;
use App\Http\Controllers\Admin\SummaryController;
/* End Admin Controllers */

use App\Http\Controllers\GlobalResourcesController;

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
    return view('index');
})->name('home');

// Route::get('/mailsent', function () {
//     return view('mailsent');
// });


Route::get('/about-us', function () {
    return view('site.about-us');
})->name('site.about');

Route::get('/services', function () {
    return view('site.services');
})->name('site.services');

Route::prefix('apply-now')->group(function(){
    Route::get('/', [DriverApplication::class, 'index'])->name('site.apply');

    Route::post('/add', [DriverApplication::class, 'create'])->name('site.apply.create');
});

Route::prefix('contact-us')->group(function(){
    Route::get('/', [Contact::class, 'index'])->name('site.contact');

    Route::post('send-message', [Contact::class, 'create'])->name('site.contact.create');
});


Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
    /*----- LFM Routes Start -----*/
//    Route::group(['prefix' => 'media'], function () {
//        Lfm::routes();
//    });
    /*----- LFM Routes End -----*/

    Route::get('/dashboard', [HomeController::class, 'index'])->middleware('can:create-Dashboard')->name('dashboard');

    /*----- Profile Routes Start -----*/
    Route::prefix('profile')->group(function () {
        Route::get('/',[ProfileController::class,'index'])->name('admin.users.profile');

        Route::post('/update-details',[ProfileController::class,'updateDetails'])->name('admin.users.profile-update-details');
        Route::post('/update-email',[ProfileController::class,'updateEmail'])->name('admin.users.profile-update-email');
        Route::post('/update-password',[ProfileController::class,'updatePassword'])->name('admin.users.profile-update-password');
        Route::post('/update-image',[ProfileController::class,'updateImage'])->name('admin.users.profile-update-image');
    });
    /*----- Profile Routes End -----*/

    /*----- Site Routes Start -----*/
    Route::prefix('site-settings')->group(function(){
        Route::get('', [SiteSettingController::class,'index'])->middleware('can:read-SiteSetting')->name('admin.site-settings');
        Route::post('update', [SiteSettingController::class,'update'])->middleware(['can:update-SiteSetting', 'password.confirm'])->name('admin.site-settings.update');
        Route::post('store', [SiteSettingController::class,'store'])->middleware('can:create-SiteSetting')->name('admin.site-settings.store');
        Route::post('delete', [SiteSettingController::class,'delete'])->middleware('can:delete-SiteSetting')->name('admin.site-settings.delete');
    });
    /*----- Site Routes End -----*/

    /*----- Load Planner Routes Start -----*/
      Route::prefix('load-planner')->group(function(){
        Route::get('/', [LoadPlannerController::class,'index'])->middleware('can:read-LoadPlanner')->name('admin.loadPlanner');

        Route::get('add', [LoadPlannerController::class,'showAddForm'])->middleware('can:create-LoadPlanner')->name('admin.loadPlanner.add');

        Route::get('details/{id}', [LoadPlannerController::class,'showDetails'])->middleware('can:read-LoadPlanner')->name('admin.loadPlanner.details');

        Route::get('edit/{id}', [LoadPlannerController::class,'showEditForm'])->middleware('can:update-LoadPlanner')->name('admin.loadPlanner.edit');

        Route::get('files-missing', [LoadPlannerController::class,'showMissingFiles'])->middleware('can:read-LoadPlanner')->name('admin.loadPlanner.missingFiles');

        Route::post('add', [LoadPlannerController::class,'create'])->middleware('can:create-LoadPlanner')->name('admin.loadPlanner.create');
        Route::post('edit', [LoadPlannerController::class,'update'])->middleware('can:update-LoadPlanner')->name('admin.loadPlanner.update');
        Route::post('remove', [LoadPlannerController::class,'delete'])->middleware('can:delete-LoadPlanner')->name('admin.loadPlanner.delete');
        Route::post('files-missing/upload', [LoadPlannerController::class,'uploadMissingFiles'])->middleware('can:update-LoadPlanner')->name('admin.loadPlanner.uploadMissingFiles');

        Route::post('mark-as-completed', [LoadPlannerController::class,'markAsCompleted'])->middleware('can:update-LoadPlanner')->name('admin.loadPlanner.completed');
        Route::post('check-loads-number', [LoadPlannerController::class, 'checkLoadnumber'])->middleware('can:read-LoadPlanner')->name('admin.loadPlanner.checkLoadnumber');

        Route::post('check-loads', [LoadPlannerController::class, 'checkLoads'])->middleware('can:read-LoadPlanner')->name('admin.loadPlanner.checkLoad');
        Route::get('check-loads', [LoadPlannerController::class,'showcheckLoads'])->middleware('can:read-LoadPlanner')->name('admin.loadPlanner.showcheckLoads');
        Route::post('mark-all-completed', [LoadPlannerController::class,'markAllCompleted'])->middleware('can:update-LoadPlanner')->name('admin.loadPlanner.Allcompleted');




    });
    /*----- Load Planner Routes End -----*/

    /*----- Expenses Routes Start -----*/
    Route::prefix('expenses')->group(function(){
        Route::get('/', [ExpenseController::class,'index'])->middleware('can:read-Expense')->name('admin.expenses');

        Route::get('add', [ExpenseController::class,'showAddForm'])->middleware('can:create-Expense')->name('admin.expenses.add');

        Route::get('edit/{id}', [ExpenseController::class,'showEditForm'])->middleware('can:update-Expense')->name('admin.expenses.edit');

        Route::post('add', [ExpenseController::class,'create'])->middleware('can:create-Expense')->name('admin.expenses.create');
        Route::post('edit', [ExpenseController::class,'update'])->middleware('can:update-Expense')->name('admin.expenses.update');
        Route::post('remove', [ExpenseController::class,'delete'])->middleware('can:delete-Expense')->name('admin.expenses.delete');
    });
    /*----- Expenses Routes End -----*/

    /*----- Fuel Expenses Routes Start -----*/
    Route::prefix('fuel-expenses')->group(function(){
        Route::get('/', [FuelExpenseController::class,'index'])->middleware('can:read-FuelExpense')->name('admin.fuelExpense');

        Route::post('import-sheet', [FuelExpenseController::class,'import'])->middleware('can:create-FuelExpense')->name('admin.fuelExpense.import');
        Route::post('remove', [FuelExpenseController::class,'delete'])->middleware('can:delete-FuelExpense')->name('admin.fuelExpense.delete');
    });
    /*----- Fuel Expenses Routes End -----*/

    /*----- Profit & Loss Routes Start -----*/
    Route::prefix('profit-and-loss')->group(function(){
        Route::get('/', [ProfitLossController::class,'index'])->middleware('can:read-ProfitLoss')->name('admin.profitLoss');
    });
    /*----- Profit & Loss Routes End -----*/

    /*----- 1099 FORM Routes Start -----*/
    Route::prefix('1099-form')->group(function(){
        Route::get('/', [TaxFormController::class,'index'])->middleware('can:read-TaxReport')->name('admin.taxForm');
    });
    /*----- 1099 FORM Routes End -----*/

    /*----- Invoices Routes Start -----*/
    Route::prefix('invoice')->group(function(){
        Route::get('/', [InvoiceController::class,'index'])->middleware('can:read-Invoice')->name('admin.invoice');

        Route::get('generate', [InvoiceController::class,'showAddForm'])->middleware('can:create-Invoice')->name('admin.invoice.add');

        Route::get('details/{id}', [InvoiceController::class,'showDetails'])->middleware('can:read-Invoice')->name('admin.invoice.details');

        Route::get('edit/{id}', [InvoiceController::class,'showEditForm'])->middleware('can:update-Invoice')->name('admin.invoice.edit');

        Route::post('add', [InvoiceController::class,'create'])->middleware('can:create-Invoice')->name('admin.invoice.create');
        Route::post('edit', [InvoiceController::class,'update'])->middleware('can:update-Invoice')->name('admin.invoice.update');
        Route::post('remove', [InvoiceController::class,'delete'])->middleware('can:delete-Invoice')->name('admin.invoice.delete');
        Route::post('finalize-invoice', [InvoiceController::class,'finalizeInvoice'])->middleware('can:update-Invoice')->name('admin.invoice.finalize');
        Route::post('mark-as-paid', [InvoiceController::class,'markPaid'])->middleware('can:update-Invoice')->name('admin.invoice.paid');
        Route::post('export-bulk-invoices', [InvoiceController::class,'exportBulk'])->middleware('can:read-Invoice')->name('admin.invoice.export');

        Route::get('print/{id}', [InvoiceController::class,'print'])->middleware('can:read-Invoice')->name('admin.invoice.print');
        Route::get('total-invoices', [InvoiceController::class,'invoicesCount'])->middleware('can:read-Invoice')->name('admin.invoice.count');

        Route::get('batch', [InvoiceBatchController::class, 'index'])->middleware('can:read-Invoice')->name('admin.invoiceBatch');

        Route::post('batch/download', [InvoiceBatchController::class, 'download'])->middleware('can:read-Invoice')->name('admin.invoiceBatch.download');
    });
    /*----- Invoices Routes End -----*/

    /*----- Driver Settlements Routes Start -----*/
    Route::prefix('/driver-settlement')->group(function(){
        Route::get('/', [DriverSettlementController::class, 'index'])->middleware('can:read-DriverSettlement')->name('admin.driverSettlement');
        Route::get('add', [DriverSettlementController::class, 'addsettlememt'])->middleware('can:read-DriverSettlement')->name('admin.driverSettlement.addsettlememt');
        Route::post('generate', [DriverSettlementController::class, 'showAddForm'])->middleware('can:create-DriverSettlement')->name('admin.driverSettlement.add');

        Route::get('details/{id}', [DriverSettlementController::class, 'showDetails'])->middleware('can:read-DriverSettlement')->name('admin.driverSettlement.details');

        Route::get('edit/{id}', [DriverSettlementController::class,'showEditForm'])->middleware('can:update-DriverSettlement')->name('admin.driverSettlement.edit');

        Route::post('add', [DriverSettlementController::class, 'create'])->middleware('can:read-DriverSettlement')->name('admin.driverSettlement.create');
        Route::post('edit', [DriverSettlementController::class, 'update'])->middleware('can:update-DriverSettlement')->name('admin.driverSettlement.update');
        Route::post('remove', [DriverSettlementController::class, 'delete'])->middleware('can:delete-DriverSettlement')->name('admin.driverSettlement.delete');
        Route::post('mark-as-paid', [DriverSettlementController::class, 'markPaid'])->middleware('can:update-DriverSettlement')->name('admin.driverSettlement.markPaid');
        Route::post('remove-deduction', [DriverSettlementController::class, 'removeDeduction'])->middleware('can:update-DriverSettlement')->name('admin.driverSettlement.removeDeduction');

        Route::post('check-trips', [DriverSettlementController::class, 'checkTrips'])->middleware('can:read-DriverSettlement')->name('admin.driverSettlement.checkTrips');

        Route::get('print/{id}', [DriverSettlementController::class, 'print'])->middleware('can:read-DriverSettlement')->name('admin.driverSettlement.print');

        Route::get('mail/{id}', [DriverSettlementController::class, 'mail'])->middleware('can:read-DriverSettlement')->name('admin.driverSettlement.mail');
    });
    /*----- Driver Settlements Routes End -----*/

    /*----- Drivers Routes Start -----*/
    Route::prefix('drivers')->group(function(){
        Route::get('/', [DriverController::class, 'index'])->middleware('can:read-Driver')->name('admin.driver');

        Route::get('add', [DriverController::class, 'showAddForm'])->middleware('can:create-Driver')->name('admin.driver.add');

        Route::get('details/{id}', [DriverController::class, 'showDetails'])->middleware('can:read-Driver')->name('admin.driver.details');

        Route::get('edit/{id}', [DriverController::class, 'showEditForm'])->middleware('can:update-Driver')->name('admin.driver.edit');

        Route::get('files-missing', [DriverController::class,'showMissingFiles'])->middleware('can:read-Driver')->name('admin.driver.missingFiles');

        Route::post('add', [DriverController::class, 'create'])->middleware('can:create-Driver')->name('admin.driver.create');
        Route::post('edit', [DriverController::class, 'update'])->middleware('can:update-Driver')->name('admin.driver.update');
        Route::post('remove', [DriverController::class, 'delete'])->middleware('can:delete-Driver')->name('admin.driver.delete');
        // Route::post('upload-image', [DriverController::class, 'uploadImage'])->middleware('can:update-Driver')->name('admin.driver.uploadImage');
        // Route::post('remove-image', [DriverController::class, 'removeImage'])->middleware('can:update-Driver')->name('admin.driver.removeImage');
    });
    /*----- Drivers Routes End -----*/

    /*----- Trash Routes Start -----*/
    Route::prefix('trash')->group(function(){
        Route::get('/', [TrashController::class, 'index'])->middleware('can:read-Trash')->name('admin.trash');

        Route::post('restore', [TrashController::class, 'restore'])->middleware('can:update-Trash')->name('admin.trash.restore');
        Route::post('remove', [TrashController::class, 'delete'])->middleware('can:delete-Trash')->name('admin.trash.delete');
        Route::post('empty', [TrashController::class, 'deleteAll'])->middleware('can:delete-Trash')->name('admin.trash.deleteAll');
    });
    /*----- Trash Routes End -----*/

    /*----- Trucks Routes Start -----*/
    Route::prefix('trucks')->group(function(){
        Route::get('/', [TruckController::class, 'index'])->middleware('can:read-Truck')->name('admin.truck');

        Route::get('add', [TruckController::class, 'showAddForm'])->middleware('can:create-Truck')->name('admin.truck.add');

        Route::get('edit/{id}', [TruckController::class, 'showEditForm'])->middleware('can:update-Truck')->name('admin.truck.edit');

        Route::get('truck-loads', [TruckController::class, 'getTruckLoads'])->middleware('can:read-Truck')->name('admin.truck.loads');

        Route::post('add', [TruckController::class, 'create'])->middleware('can:read-Truck')->name('admin.truck.create');
        Route::post('edit', [TruckController::class, 'update'])->middleware('can:update-Truck')->name('admin.truck.update');
        Route::post('remove', [TruckController::class, 'delete'])->middleware('can:delete-Truck')->name('admin.truck.delete');
    });
    /*----- Trucks Routes End -----*/

    /*----- Locations Routes Start -----*/
    Route::prefix('locations')->group(function(){
        Route::get('/', [LocationController::class, 'index'])->middleware('can:read-Location')->name('admin.location');

        Route::get('/json', [LocationController::class, 'fetchAjax'])->middleware('can:read-Location')->name('admin.location.ajax');

        Route::get('/list-json', [LocationController::class, 'fetchLocations'])->middleware('can:read-Location')->name('admin.location.all');
		Route::get('/list-all-json', [LocationController::class, 'fetchAllLocations'])->middleware('can:read-Location')->name('admin.location.fetch-all');

        Route::get('add', [LocationController::class, 'showAddForm'])->middleware('can:create-Location')->name('admin.location.add');

        Route::get('details/{id?}', [LocationController::class, 'showDetails'])->middleware('can:read-Location')->name('admin.location.details');

        Route::get('edit/{id?}', [LocationController::class, 'showEditForm'])->middleware('can:update-Location')->name('admin.location.edit');

        Route::post('add', [LocationController::class, 'create'])->middleware('can:read-Location')->name('admin.location.create');
        Route::post('edit', [LocationController::class, 'update'])->middleware('can:update-Location')->name('admin.location.update');
        Route::post('remove', [LocationController::class, 'delete'])->middleware('can:delete-Location')->name('admin.location.delete');

        Route::get('fetch-location', [LocationController::class, 'fetchLocation'])->middleware('can:read-Location')->name('admin.location.fetchLocation');
    });
    /*----- Locations Routes End -----*/

    /*----- Customers Routes Start -----*/
    Route::prefix('customers')->group(function(){
        Route::get('/', [CustomerController::class, 'index'])->middleware('can:read-Customer')->name('admin.customer');

        Route::get('json', [CustomerController::class, 'fetchAjax'])->middleware('can:read-Customer')->name('admin.customer.ajax');

        Route::get('list-json', [CustomerController::class, 'fetchCustomers'])->middleware('can:read-Customer')->name('admin.customer.all');
		Route::get('list-all-json', [CustomerController::class, 'fetchAllCustomers'])->middleware('can:read-Customer')->name('admin.customer.fetch_all');

        Route::get('add', [CustomerController::class, 'showAddForm'])->middleware('can:create-Customer')->name('admin.customer.add');

        Route::get('details/{id?}', [CustomerController::class, 'showDetails'])->middleware('can:read-Customer')->name('admin.customer.details');

        Route::get('edit/{id?}', [CustomerController::class, 'showEditForm'])->middleware('can:update-Customer')->name('admin.customer.edit');

        Route::post('add', [CustomerController::class, 'create'])->middleware('can:read-Customer')->name('admin.customer.create');
        Route::post('edit', [CustomerController::class, 'update'])->middleware('can:update-Customer')->name('admin.customer.update');
        Route::post('remove', [CustomerController::class, 'delete'])->middleware('can:delete-Customer')->name('admin.customer.delete');
    });
    /*----- Customers Routes End -----*/

    /*----- Factoring Company Routes Start -----*/
    Route::prefix('factoring-companies')->group(function(){
        Route::get('/', [FactoringCompanyController::class, 'index'])->middleware('can:read-Factoring')->name('admin.factoringCompanies');

        Route::get('add', [FactoringCompanyController::class, 'showAddForm'])->middleware('can:create-Factoring')->name('admin.factoringCompanies.add');

        Route::get('edit/{id}', [FactoringCompanyController::class, 'showEditForm'])->middleware('can:update-Factoring')->name('admin.factoringCompanies.edit');

        Route::post('add', [FactoringCompanyController::class, 'create'])->middleware('can:create-Factoring')->name('admin.factoringCompanies.create');
        Route::post('edit', [FactoringCompanyController::class, 'update'])->middleware('can:update-Factoring')->name('admin.factoringCompanies.update');
        Route::post('remove', [FactoringCompanyController::class, 'delete'])->middleware('can:delete-Factoring')->name('admin.factoringCompanies.delete');
    });
    /*----- Factoring Company Routes End -----*/

    /*----- Driver Applications Routes Start -----*/
    Route::prefix('driver-application')->group(function(){
        Route::get('/', [DriverApplicationController::class, 'index'])->middleware('can:read-DriverApplication')->name('admin.driverApplication');

        Route::get('details/{id}', [DriverApplicationController::class, 'showDetails'])->middleware('can:read-DriverApplication')->name('admin.driverApplication.details');

        Route::post('remove', [DriverApplicationController::class, 'delete'])->middleware('can:delete-DriverApplication')->name('admin.driverApplication.delete');
    });
    /*----- Driver Applications Routes End -----*/

    /*----- Archives Routes Start -----*/
    Route::prefix('archives')->group(function(){
        Route::get('/', [ArchiveController::class, 'index'])->middleware('can:read-Archive')->name('admin.archive');

        Route::post('add', [ArchiveController::class, 'create'])->middleware('can:create-Archive')->name('admin.archive.create');
        Route::post('edit', [ArchiveController::class, 'update'])->middleware('can:update-Archive')->name('admin.archive.update');
        Route::post('remove', [ArchiveController::class, 'delete'])->middleware('can:delete-Archive')->name('admin.archive.delete');
    });
    /*----- Archives Routes End -----*/

    /*----- Expense Category Routes Start -----*/
    Route::prefix('expense-categories')->group(function(){
        Route::get('/', [ExpenseCategoryController::class, 'index'])->middleware('can:read-ExpenseCategory')->name('admin.expenseCategory');

        Route::post('add', [ExpenseCategoryController::class, 'create'])->middleware('can:create-ExpenseCategory')->name('admin.expenseCategory.create');
        Route::post('edit', [ExpenseCategoryController::class, 'update'])->middleware('can:update-ExpenseCategory')->name('admin.expenseCategory.update');
        Route::post('remove', [ExpenseCategoryController::class, 'delete'])->middleware('can:delete-ExpenseCategory')->name('admin.expenseCategory.delete');
    });
    /*----- Expense Category Routes End -----*/

    /*----- Deduction Category Routes Start -----*/
    Route::prefix('deduction-categories')->group(function(){
        Route::get('/', [DeductionCategoryController::class, 'index'])->middleware('can:read-DeductionCategory')->name('admin.deductionCategory');

        Route::post('add', [DeductionCategoryController::class, 'create'])->middleware('can:create-DeductionCategory')->name('admin.deductionCategory.create');
        Route::post('edit', [DeductionCategoryController::class, 'update'])->middleware('can:update-DeductionCategory')->name('admin.deductionCategory.update');
        Route::post('remove', [DeductionCategoryController::class, 'delete'])->middleware('can:delete-DeductionCategory')->name('admin.deductionCategory.delete');
    });
    /*----- Deduction Category Routes End -----*/

    /*----- Permission Routes Start -----*/
    Route::prefix('permissions')->group(function(){
        Route::get('/', [PermissionController::class,'index'])->middleware('can:read-Permission')->name('admin.permissions');
        Route::get('view/{id}', [PermissionController::class,'showDetails'])->middleware('can:read-Permission')->name('admin.permissions.view');
        Route::get('add', [PermissionController::class,'showAddForm'])->middleware('can:create-Permission')->name('admin.permissions.create');
        Route::get('edit/{id}', [PermissionController::class,'showEditForm'])->middleware('can:update-Permission')->name('admin.permissions.edit');

        Route::post('add', [PermissionController::class,'create'])->middleware('can:create-Permission')->name('admin.permissions.store');
        Route::post('edit', [PermissionController::class,'update'])->middleware('can:update-Permission')->name('admin.permissions.update');
        Route::post('remove', [PermissionController::class,'delete'])->middleware('can:delete-Permission')->name('admin.permissions.delete');
    });
    /*----- Permission Routes End -----*/

    /*----- Users Routes Start -----*/
    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'index'])->middleware('can:read-User')->name('admin.users');
        Route::get('/view/{id}', [UserController::class, 'view'])->middleware('can:read-User')->name('admin.users.view');
        Route::get('/add', [UserController::class, 'create'])->middleware('can:create-User')->name('admin.users.create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->middleware('can:update-User')->name('admin.users.edit');

        Route::post('/store', [UserController::class, 'store'])->middleware('can:create-User')->name('admin.users.store');
        Route::post('/update', [UserController::class, 'update'])->middleware('can:update-User')->name('admin.users.update');
        Route::post('/delete', [UserController::class, 'delete'])->middleware('can:delete-User')->name('admin.users.delete');
        Route::post('/enable-disable', [UserController::class, 'enableDisable'])->middleware('can:update-User')->name('admin.users.enableDisable');
    });
    /*----- Users Routes End -----*/

    /*----- Modules Routes Start -----*/
    Route::prefix('modules')->group(function(){
        Route::get('/', [ModuleController::class, 'index'])->name('admin.modules');

        Route::post('add', [ModuleController::class, 'create'])->name('admin.modules.store');
        Route::post('update', [ModuleController::class, 'update'])->name('admin.modules.update');
    });
    /*----- Modules Routes End -----*/

    /*----- Contact Us Routes Start -----*/
    Route::prefix('contact-us')->group(function(){
        Route::get('/', [ContactController::class,'index'])->middleware('can:read-ContactUs')->name('admin.contacts');

        Route::post('read', [ContactController::class,'read'])->middleware('can:read-ContactUs')->name('admin.contacts.read');
    });
    /*----- Contact Us Routes End -----*/

    /*----- Reports Routes Start -----*/
    Route::prefix('reports')->group(function(){
        Route::get('driver-settlement', [ReportController::class, 'driverSettlement'])->middleware('can:create-Report')->name('admin.report.settlement');
        Route::get('driver-settlement/print', [ReportController::class, 'printDriverSettlement'])->middleware('can:read-Report')->name('admin.report.settlement.print');

        Route::get('factoring-fee', [ReportController::class, 'factoringFee'])->middleware('can:create-Report')->name('admin.report.factoring');
        Route::get('factoring-fee/print', [ReportController::class, 'printfactoringFee'])->middleware('can:read-Report')->name('admin.report.factoring.print');
    });
    /*----- Reports Routes End -----*/

    /*----- Reports Routes Start -----*/
    Route::prefix('recurring-deductions')->group(function(){
        Route::get('/', [RecurringDeductionController::class, 'index'])->middleware('can:create-RecurringDeduction')->name('admin.recurringDeduction');

        Route::post('add', [RecurringDeductionController::class, 'create'])->middleware('can:create-RecurringDeduction')->name('admin.recurringDeduction.create');
        Route::post('edit', [RecurringDeductionController::class, 'update'])->middleware('can:update-RecurringDeduction')->name('admin.recurringDeduction.update');
        Route::post('remove', [RecurringDeductionController::class, 'delete'])->middleware('can:delete-RecurringDeduction')->name('admin.recurringDeduction.delete');
    });
    /*----- Reports Routes End -----*/

    /*----- States & Cities Routes Start -----*/
    Route::prefix('states-and-cities')->group(function(){
        Route::get('/', [StateCityController::class, 'index'])->middleware('can:read-StateCity')->name('admin.stateCity');

        Route::get('/states-json', [StateCityController::class, 'fetchStatesJson'])->middleware('can:read-StateCity')->name('admin.stateCity.ajaxState');

        Route::get('/cities-json', [StateCityController::class, 'fetchCitiesJson'])->middleware('can:read-StateCity')->name('admin.stateCity.ajaxCity');

        Route::post('add-state', [StateCityController::class, 'createState'])->middleware('can:create-StateCity')->name('admin.stateCity.createState');
        Route::post('add-city', [StateCityController::class, 'createCity'])->middleware('can:create-StateCity')->name('admin.stateCity.createCity');
        Route::post('edit-state', [StateCityController::class, 'updateState'])->middleware('can:update-StateCity')->name('admin.stateCity.updateState');
        Route::post('edit-city', [StateCityController::class, 'updateCity'])->middleware('can:update-StateCity')->name('admin.stateCity.updateCity');
    });
    /*----- States & Cities Routes End -----*/

    /*----- Summary Routes Start -----*/
    Route::get('/summary', [SummaryController::class, 'index'])->middleware('can:read-Summary')->name('summary');
    /*----- Summary Routes End -----*/

    /*----- Sheet Importing Routes Routes Start -----*/
    // Route::prefix('import')->group(function(){
    //     Route::post('drivers', [DriverController::class, 'importSheet'])->name('admin.import.drivers');
    //     Route::post('customers', [CustomerController::class, 'importSheet'])->name('admin.import.customers');
    //     Route::post('trucks', [TruckController::class, 'importSheet'])->name('admin.import.trucks');
    //     Route::post('locations', [LocationController::class, 'importSheet'])->name('admin.import.locations');
    // });
    /*----- Sheet Importing Routes Routes End -----*/
});

/*----- Global Resource Provider Routes Start -----*/
Route::get('resource-provider/states', [GlobalResourcesController::class, 'fetchStatesByCountry']);
Route::get('resource-provider/cities', [GlobalResourcesController::class, 'fetchCitiesByState']);
Route::get('resource-provider/search-city', [GlobalResourcesController::class, 'searchCityByKeyword'])->name('resource.search-city');
/*----- Global Resource Provider Routes End -----*/

require __DIR__.'/auth.php';
