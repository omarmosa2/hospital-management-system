<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PatientFileController;
use App\Http\Controllers\ReceptionController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes (handled by Fortify)
Route::middleware(['auth:web'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Clinic routes
    Route::resource('clinics', ClinicController::class);
    
    // Doctor routes
    Route::resource('doctors', DoctorController::class);
    
    // Patient routes
    Route::resource('patients', PatientController::class);
    
    // Appointment routes
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
        ->name('appointments.confirm');
    Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])
        ->name('appointments.complete');
    
    // Medical Record routes
    Route::resource('medical-records', MedicalRecordController::class);
    
    // Prescription routes
    Route::resource('prescriptions', PrescriptionController::class);
    
    // Bill routes (redirect to expenses)
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
    
    // Service routes
    Route::resource('services', ServiceController::class);
    
    // Doctor fee route
    Route::get('/doctors/{doctor}/fee', [DoctorController::class, 'getFee'])->name('doctors.fee');
    
    // Clinic working hours route
    Route::get('/clinics/{clinic}/working-hours', [DoctorController::class, 'getClinicWorkingHours'])->name('clinics.working-hours');
    
    // Salary routes
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
    
    // Expense routes (replacing bills)
    Route::resource('expenses', ExpenseController::class);
    Route::post('/expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
    Route::post('/expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');
    Route::post('/expenses/{expense}/mark-paid', [ExpenseController::class, 'markPaid'])->name('expenses.markPaid');
    
    // Account management routes
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{user}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{user}', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{user}', [AccountController::class, 'destroy'])->name('accounts.destroy');
    Route::post('/accounts/{user}/toggle-status', [AccountController::class, 'toggleStatus'])->name('accounts.toggleStatus');
    Route::post('/accounts/{user}/reset-password', [AccountController::class, 'resetPassword'])->name('accounts.resetPassword');
    
    // Patient Files routes
    Route::get('/patient-files', [PatientFileController::class, 'index'])->name('patient-files.index');
    Route::get('/patient-files/{patient}', [PatientFileController::class, 'show'])->name('patient-files.show');
    Route::get('/patient-files/{patient}/pdf', [PatientFileController::class, 'generatePdf'])->name('patient-files.generate-pdf');
    Route::get('/patient-files/{patient}/print', [PatientFileController::class, 'print'])->name('patient-files.print');
    
    // Reception routes (read-only access)
    Route::prefix('reception')->name('reception.')->group(function () {
        Route::get('/clinics', [ReceptionController::class, 'clinicsIndex'])->name('clinics.index');
        Route::get('/clinics/{clinic}', [ReceptionController::class, 'clinicsShow'])->name('clinics.show');
        Route::get('/doctors', [ReceptionController::class, 'doctorsIndex'])->name('doctors.index');
        Route::get('/doctors/{doctor}', [ReceptionController::class, 'doctorsShow'])->name('doctors.show');
    });
});
