<?php

// Include Routing Functions
use Illuminate\Support\Facades\Route;

// Include Employees Controller
use App\Http\Controllers\UserController;

// Include Employees Controller
use App\Http\Controllers\AnnouncementsController;

// Include File Attachments Controller
use App\Http\Controllers\AttachmentsController;

// Include Employees Controller
use App\Http\Controllers\LeavesController;

// Include Notes Controller
use App\Http\Controllers\NotesController;

// Include Employees Controller
use App\Http\Controllers\CompaniesController;

// Include Employees Controller
use App\Http\Controllers\ReportsController;

// Include Employees Controller
use App\Http\Controllers\PassportsController;

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

//=========================================================================
//  Public Routes
//=========================================================================

    // Login
    Route::get('/', function() {
        return view('admin.employee.login');
    })->name('login');

    // Fixed Function : Get Employees Nationality Count & Percentages
    Route::get('/dashboard', function() {
        $boxes = (new ReportsController)->boxes();
        return view('index', compact('boxes'));
    })->name('dashboard');

//--------------------------------------------------------------------
//  Employee Routes
//--------------------------------------------------------------------

    Route::prefix('employees')->group(function() {

        // All Employees
        Route::get('/all', function() {
            $type       = "all";
            $employees  = (new UserController)->index();
            return view('admin.employee.list', compact('type','employees'));
        });

        // Native Employees
        Route::get('/natives', function() {
            $type       = "natives";
            $employees  = (new UserController)->native();
            return view('admin.employee.list', compact('type','employees'));
        });

        // Expatriates Employees
        Route::get('/expatriates', function() {
            $type       = "expatriates";
            $employees  = (new UserController)->expatriate();
            return view('admin.employee.list', compact('type','employees'));
        });

        // Employees Expiries
        Route::get('/expiries', function() {
            $type       = "expiries";
            $employees  = (new UserController)->expiries();
            return view('admin.employee.list', compact('type','employees'));
        });

        // Employees With Incomplete Profiles
        Route::get('/males', function() {
            $type       = "males";
            $employees  = (new UserController)->males();
            return view('admin.employee.list', compact('type','employees'));
        });

        // Employees With Incomplete Profiles
        Route::get('/females', function() {
            $type       = "females";
            $employees  = (new UserController)->females();
            return view('admin.employee.list', compact('type','employees'));
        });

        // Employees With Incomplete Profiles
        Route::get('/incomplete', function() {
            $type       = "incomplete";
            $employees  = (new UserController)->incomplete();
            return view('admin.employee.list', compact('type', 'employees'));
        });

        // Employees Passports In Deposits
        Route::get('/deposits', function() {
            $type       = "deposits";
            $employees  = (new UserController)->deposits();
            return view('admin.employee.list', compact('type', 'employees'));
        });

        // Employees Passports In Deposits
        Route::get('/ex', function() {
            $type       = "ex";
            $employees  = (new UserController)->ex();
            return view('admin.employee.list', compact('type', 'employees'));
        });

        // Fixed Function : Get Employees Nationality Count & Percentages
        Route::get('/{id}', function($id) {
            $profile    = (new UserController)->show($id);
            $leaves     = (new LeavesController)->show($id);
            $notes      = (new NotesController)->show($id);
            $passports  = (new PassportsController)->show($id);
            $files      = (new AttachmentsController)->show($id);
            return view('admin.employee.profile', compact('profile', 'leaves', 'notes', 'passports', 'files'));
        })->name('profile');

        // Returns All Employees By Name Referance
        Route::get('/name/{name}', function($name) {
            $results = (new UserController)->findByName($name);
            return view('welcome', compact('results'));
        });

        // Returns All Employees By Company Referance
        Route::get('/company/{company}', function($company) {
            $results = (new UserController)->findByCompany($company);
            return view('welcome', compact('results'));
        });

        // Returns All Employees By CPR Referance
        Route::get('/cpr/{cpr}', function($cpr) {
            $results = (new UserController)->findByCPR($cpr);
            return view('welcome', compact('results'));
        });

        // Returns All Employees By Passport Referance
        Route::get('/passport/{passport}', function($passport) {
            $results = (new UserController)->findByPassport($passport);
            return view('welcome', compact('results'));
        });

        // Returns All Employees By Visa Referance
        Route::get('/visa/{visa}', function($visa) {
            $results = (new UserController)->findByVisa($visa);
            return view('welcome', compact('results'));
        });

    });

//--------------------------------------------------------------------
//  Notes
//--------------------------------------------------------------------

    Route::prefix('notes')->group(function() {

        // Creating A New Note
        Route::post('/write', [NotesController::class, 'store']);

        // Delete A Note
        Route::get('/delete/{id}', function($id) {
            (new NotesController)->destroy($id);
            return redirect(url()->previous());
        });

    });

//--------------------------------------------------------------------
//  Enterprise Routes
//--------------------------------------------------------------------

    Route::prefix('enterprise')->group(function() {

        // All Employees
        Route::get('/companies', function() {
            $companies  = (new CompaniesController)->index();
            return view('admin.enterprice.company.list', compact('companies'));
        })->name('list.companies');

        // Native Employees
        Route::get('/departments', function() {
            $departments  = (new UserController)->native();
            return view('admin.enterprice.department.list', compact('departments'));
        })->name('list.departments');

        // Expatriates Employees
        Route::get('/visas', function() {
            $visas  = (new UserController)->expatriate();
            return view('admin.enterprice.visa.list', compact('visas'));
        })->name('list.visas');

    });

//--------------------------------------------------------------------
//  Companies Routes
//--------------------------------------------------------------------
