<?php

//=========================================================================
//  Includes Of The Controllers For The Routes
//=========================================================================

    // Include Request Library
    use Illuminate\Http\Request;

    // Include Routes Library
    use Illuminate\Support\Facades\Route;

    // Include Employees Controller
    use App\Http\Controllers\AnnouncementsController;

    // Include Employees Controller
    use App\Http\Controllers\LeavesController;

    // Include Employees Controller
    use App\Http\Controllers\UserController;

    // Include Employees Controller
    use App\Http\Controllers\ReportsController;

    // Include Employees Controller
    use App\Http\Controllers\PassportsController;

    // Include Employees Controller
    use App\Http\Controllers\NotesController;

    // Sanctum Authentication Controller
    use App\Http\Controllers\AuthController;

    // Sanctum Visas Controller
    use App\Http\Controllers\VisasController;

    // Sanctum Companies Controller
    use App\Http\Controllers\CompaniesController;

//=========================================================================
//  Public Routes
//=========================================================================

    // Sanctum Login
    Route::post('/login', [AuthController::class, 'login']);

    // Sanctum Register
    Route::post('/register', [AuthController::class, 'register']);

    // Employee Logout
    // Route::post('/logout', [AuthController::class, 'logout']); 

//=========================================================================
//  Protected Routes
//=========================================================================

    // Protected Routes
    // Route::group(['middleware'=> ['auth:sanctum']], function () {

        // Show all Leaves Regardsless Of Status
        Route::get('leaves/all', [LeavesController::class, 'index']);

        // Get All Pending Leaves
        Route::get('leaves/pending/all', [LeavesController::class, 'pendingReq']);

        // Get Leaves Of an Employee By ID
        Route::get('leaves/id/{id}', [LeavesController::class, 'show']);

        // Get All Valid Leaves Request By Employee ID
        Route::get('leaves/valid/{id}', [LeavesController::class, 'valid']);

        // Get All Leaves Request Between Duration Of A Specific Employee
        Route::get('leaves/duration/{id}/{start}/{end}', [LeavesController::class, 'findByDuration']);

        // Create A New Leave Request
        Route::post('leaves/add', [LeavesController::class, 'store']);

        // Update Leaves Of an Employee By ID
        Route::put('leaves/update/{id}', [LeavesController::class, 'update']);

        // Delete A Leave Request By ID
        Route::delete('leaves/delete/{id}', [LeavesController::class, 'destroy']);

    //-------------------------------------------------------------------------
    //  Announcements Routes
    //-------------------------------------------------------------------------

        // Get All Announcements
        Route::get('announcements/all', [AnnouncementsController::class, 'index']);

        // Get An Announcements By ID
        Route::get('/announcements/valid/all', [AnnouncementsController::class, 'valid']);

        // Get An Announcements By ID
        Route::get('announcements/id/{id}', [AnnouncementsController::class, 'show']);

        // Get All Announcements By Title Content
        Route::get('announcements/title/{title}', [AnnouncementsController::class, 'findByTitle']);

        // Get All Announcements By Body Content
        Route::get('announcements/body/{body}', [AnnouncementsController::class, 'findByBody']);

        // Get All Announcements Between Duration
        Route::get('announcements/duration/{start}/{end}', [AnnouncementsController::class, 'findByDuration']);

        // Create A New Announcement
        Route::post('announcements/add', [AnnouncementsController::class, 'store']);

        // Update An Announcement By ID
        Route::put('announcements/update/{id}', [AnnouncementsController::class, 'update']);

        // Delete An Announcement By ID
        Route::delete('announcements/delete/{id}', [AnnouncementsController::class, 'destroy']);

    //-------------------------------------------------------------------------
    //  Employees Routes
    //-------------------------------------------------------------------------

        // Fixed Function : All Employees
        Route::get('employees/all', [UserController::class, 'index']);

        // Fixed Function : Search
        Route::get('employees/search/{info}', [UserController::class, 'search']);

        // Fixed Function : Get All Male Employees
        Route::get('employees/ex/all', [UserController::class, 'ex']);

        // Fixed Function : Get All Male Employees
        Route::get('employees/ex/search/{input}', [UserController::class, 'exemp']);

        // Fixed Function : Get All Passport Transactions
        Route::get('employees/passport/all', [PassportsController::class, 'index']);

        // Fixed Function : Insert Passport Transaction
        Route::post('employees/passport/add', [PassportsController::class, 'store']);

        // Fixed Function : Employees Passports In Deposits
        Route::get('employees/passport/deposit/all', [UserController::class, 'deposits']);

        // Fixed Function : Get All Male Employees
        Route::get('employees/male/all', [UserController::class, 'males']);

        // Fixed Function : Get All Male Employees
        Route::get('employees/male/search/{input}', [UserController::class, 'males']);

        // Fixed Function : Get All Female Employees
        Route::get('employees/female/all', [UserController::class, 'females']);

        // Fixed Function : Get All Female Employees
        Route::get('employees/female/search/{input}', [UserController::class, 'females']);

        // Fixed Function : Get All Native Employees
        Route::get('employees/native/all', [UserController::class, 'native']);

        // Fixed Function : Get All Native Employees
        Route::get('employees/native/search/{input}', [UserController::class, 'native']);

        // Fixed Function : Get All Expatriates Employees
        Route::get('employees/expatriate/all', [UserController::class, 'expatriate']);

        // Fixed Function : Get All Expatriates Employees
        Route::get('employees/expatriate/search/{input}', [UserController::class, 'expatriate']);

        // Fixed Function : Employees Expiries
        Route::get('employees/expire/all', [UserController::class, 'expiries']);

        // Fixed Function : Employees Expiries
        Route::get('employees/expire/search/{input}', [UserController::class, 'expiries']);

        // Fixed Function : Employees With Incomplete Profiles
        Route::get('employees/incomplete/all', [UserController::class, 'incomplete']);

        // Fixed Function : Employees With Incomplete Profiles
        Route::get('employees/incomplete/search/{input}', [UserController::class, 'incomplete']);

        // Create A New Employee
        Route::post('employees/add', [UserController::class, 'store']);

        // Update An Employee By ID
        Route::put('employees/update/{id}', [UserController::class, 'update']);

        // Delete An Employee By ID
        Route::delete('employees/delete/{id}', [UserController::class, 'destroy']);

        // Returns Employee By ID
        Route::get('employees/id/{id}', [UserController::class, 'show']);

        // Returns All Employees By Name Referance
        Route::get('employees/name/{name}', [UserController::class, 'findByName']);

        // Returns All Employees By Name Referance
        Route::get('employees/cpr/{cpr}', [UserController::class, 'findByCPR']);

        // Returns All Employees By Company Referance
        Route::get('employees/company/{company}', [UserController::class, 'findByCompany']);

        // Returns All Employees By Visa Referance
        Route::get('employees/visa/{visa}', [UserController::class, 'findByVisa']);

        // Image Upload
        // Route::post('employees/upload', [UserController::class, 'dummyUpdate']);

    //-------------------------------------------------------------------------
    //  Statistics Routes
    //-------------------------------------------------------------------------

        // Fixed Function : Get Employees Nationality Count & Percentages
        Route::get('statistics/boxes', [ReportsController::class, 'boxes']);

        // Fixed Function : Get Onleave People Lite Information
        Route::get('statistics/onleave', [ReportsController::class, 'OnLeaveLite']);

        // Fixed Function : Get Anniversary People Lite Information
        Route::get('statistics/anniversary', [ReportsController::class, 'AnniversaryLite']);    // Need to Fixed - Should Be Only People Above One Year

        // Fixed Function : Get Probation People Lite Information
        Route::get('statistics/probation', [ReportsController::class, 'ProbationLite']);

        // Fixed Function : Get Probation People Lite Information
        Route::get('statistics/birthday', [ReportsController::class, 'BirthdayLite']);

        // Fixed Function : Get Employees Nationality Count & Percentages
        Route::get('statistics/nationality', [ReportsController::class, 'country']);

        // Fixed Function : Get Male/Female Percentage
        Route::get('statistics/gender', [ReportsController::class, 'gender']);

        // Fixed Function : Get Company Employees Percentage
        Route::get('statistics/company', [ReportsController::class, 'company']);

        // Fixed Function : Get Company Employees Percentage
        Route::get('statistics/visa', [ReportsController::class, 'visa']);

        // Fixed Function : Deposit Count
        Route::get('statistics/passport', [ReportsController::class, 'passport']);

    //-------------------------------------------------------------------------
    //  Notes Routes
    //-------------------------------------------------------------------------

        // Fixed Function : Get A Specific Employee Notes
        Route::get('notes/all', [NotesController::class, 'index']);  // NO FUNCTION IN CONTROLLER

        // Fixed Function : Get A Note By Its ID
        Route::get('notes/id/{id}', [NotesController::class, 'show']);  // NOT WORKING

        // Fixed Function : Add Notes To Employees
        Route::post('notes/add', [NotesController::class, 'store']);

        // Fixed Function : Get A Specific Employee Notes
        Route::get('notes/employee/{id}', [NotesController::class, 'findByEmployee']);  // NOT WORKING

        // Fixed Function : Delete A Note By Its ID
        Route::delete('notes/delete/{id}', [NotesController::class, 'destroy'])->name('delete.note');

        // Fixed Function : Get Employees Nationality Count & Percentages
        Route::put('notes/update/{id}', [NotesController::class, 'update']);

    //-------------------------------------------------------------------------
    //  Visas Routes
    //-------------------------------------------------------------------------

        // Fixed Function : Get A Specific Employee Notes
        Route::get('visas/all', [VisasController::class, 'index']);    
    
        // Fixed Function : Get A Note By Its ID
        Route::get('visas/id/{id}', [VisasController::class, 'show']);

        // Fixed Function : Add Notes To Employees
        Route::post('visas/add', [VisasController::class, 'store']);

        // Fixed Function : Get Employees Nationality Count & Percentages
        Route::put('visas/update/{id}', [VisasController::class, 'update']);

        // Fixed Function : Delete A Note By Its ID
        Route::delete('visas/delete/{id}', [VisasController::class, 'destroy'])->name('delete.note');

    //-------------------------------------------------------------------------
    //  Companies Routes
    //-------------------------------------------------------------------------

        // Fixed Function : Get A Note By Its ID
        Route::get('companies/all', [CompaniesController::class, 'index']);

        // Fixed Function : Get A Note By Its ID
        Route::get('companies/id/{id}', [CompaniesController::class, 'show']);

        // Fixed Function : Add Notes To Employees
        Route::post('companies/add', [CompaniesController::class, 'store']);

        // Fixed Function : Delete A Note By Its ID
        Route::delete('companies/delete/{id}', [CompaniesController::class, 'destroy'])->name('delete.note');

        // Fixed Function : Get Employees Nationality Count & Percentages
        Route::put('companies/update/{id}', [CompaniesController::class, 'update']);
        

//=========================================================================
//  End Of Protected Routes
//=========================================================================

        // Employee Logout
        Route::post('/logout', [AuthController::class, 'logout']);  

    // }); // Dont Touch Me
