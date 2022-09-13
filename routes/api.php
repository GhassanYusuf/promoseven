<?php

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

//=========================================================================
//  Public Routes
//=========================================================================


    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

//=========================================================================
//  Protected Routes
//=========================================================================

    // Protected Routes
    Route::group(['middleware'=> ['auth:sanctum']], function () {

        Route::prefix('leaves')->group(function() {

            // Show all Leaves Regardsless Of Status
            Route::get('/', [LeavesController::class, 'index']);        // Not Working

            // Create A New Leave Request
            Route::post('/', [LeavesController::class, 'store']);       // Not Working

            // Get Leaves Of an Employee By ID
            Route::get('/{id}', [LeavesController::class, 'show']);     // Select By Employee ID

            // Update Leaves Of an Employee By ID
            Route::put('/{id}', [LeavesController::class, 'update']);   // Not Working

            // Get All Pending Leaves
            Route::get('/pending', [LeavesController::class, 'pendingReq']);

            // Delete A Leave Request By ID
            Route::delete('/{id}', [LeavesController::class, 'destroy']);

            // Get All Valid Leaves Request By Employee ID
            Route::get('/valid/{id}', [LeavesController::class, 'valid']);

            // Get All Leaves Request Between Duration Of A Specific Employee
            Route::get('/duration/{id}/{start}/{end}', [LeavesController::class, 'findByDuration']);

        });

    //-------------------------------------------------------------------------
    //  Announcements Routes
    //-------------------------------------------------------------------------

        Route::prefix('announcements')->group(function() {

            // Get All Announcements
            Route::get('/', [AnnouncementsController::class, 'index']);

            // Get An Announcements By ID
            Route::get('/{id}', [AnnouncementsController::class, 'show']);

            // Get All Announcements By Title Content
            Route::get('/title/{title}', [AnnouncementsController::class, 'findByTitle']);

            // Get All Announcements By Body Content
            Route::get('/body/{body}', [AnnouncementsController::class, 'findByBody']);

            // Get An Announcements By ID
            Route::get('/valid', [AnnouncementsController::class, 'valid']);

            // Get All Announcements Between Duration
            Route::get('/duration/{start}/{end}', [AnnouncementsController::class, 'findByDuration']);

            // Create A New Announcement
            Route::post('/', [AnnouncementsController::class, 'store']);

            // Update An Announcement By ID
            Route::put('/{id}', [AnnouncementsController::class, 'update']);

            // Delete An Announcement By ID
            Route::delete('/{id}', [AnnouncementsController::class, 'destroy']);

        });

    //-------------------------------------------------------------------------
    //  Employees Routes
    //-------------------------------------------------------------------------

        Route::prefix('employees')->group(function() {

            // Fixed Function : All Employees
            Route::get('/', [UserController::class, 'index']);

            // Fixed Function : Get All Male Employees
            Route::get('/ex', [UserController::class, 'ex']);

            Route::post('/passport', [PassportsController::class, 'store']);

            Route::get('/passport', [PassportsController::class, 'index']);

            // Fixed Function : Get All Male Employees
            Route::get('/ex/{input}', [UserController::class, 'exemp']);

            // Fixed Function : Get All Male Employees
            Route::get('/male', [UserController::class, 'males']);

            // Fixed Function : Get All Male Employees
            Route::get('/male/{input}', [UserController::class, 'males']);

            // Fixed Function : Get All Female Employees
            Route::get('/female', [UserController::class, 'females']);

            // Fixed Function : Get All Female Employees
            Route::get('/female/{input}', [UserController::class, 'females']);

            // Fixed Function : Get All Native Employees
            Route::get('/native', [UserController::class, 'native']);

            // Fixed Function : Get All Native Employees
            Route::get('/native/{input}', [UserController::class, 'native']);

            // Fixed Function : Get All Expatriates Employees
            Route::get('/expatriate', [UserController::class, 'expatriate']);

            // Fixed Function : Get All Expatriates Employees
            Route::get('/expatriate/{input}', [UserController::class, 'expatriate']);

            // Fixed Function : Employees Expiries
            Route::get('/expire', [UserController::class, 'expiries']);

            // Fixed Function : Employees Expiries
            Route::get('/expire/{input}', [UserController::class, 'expiries']);

            // Fixed Function : Employees With Incomplete Profiles
            Route::get('/incomplete', [UserController::class, 'incomplete']);

            // Fixed Function : Employees With Incomplete Profiles
            Route::get('/incomplete/{input}', [UserController::class, 'incomplete']);

            // Fixed Function : Employees Passports In Deposits
            Route::get('/deposit', [UserController::class, 'deposits']);

            // Fixed Function : Employees Passports In Deposits
            Route::get('/deposit/{id}', [UserController::class, 'deposits']);

            // Create A New Employee
            Route::post('/', [UserController::class, 'store']);

            // Update An Employee By ID
            Route::put('/{id}', [UserController::class, 'update']);

            // Delete An Employee By ID
            Route::delete('/{id}', [UserController::class, 'destroy']);

            // Returns Employee By ID
            Route::get('/{id}', [UserController::class, 'show']);

            // Returns All Employees By Name Referance
            Route::get('/name/{name}', [UserController::class, 'findByName']);

            // Returns All Employees By Name Referance
            Route::get('/cpr/{cpr}', [UserController::class, 'findByCPR']);

            // Returns All Employees By Company Referance
            Route::get('/company/{company}', [UserController::class, 'findByCompany']);

            // Returns All Employees By Visa Referance
            Route::get('/visa/{visa}', [UserController::class, 'findByVisa']);

            // Image Upload
            Route::post('/upload', [UserController::class, 'dummyUpdate']);

        });

    //-------------------------------------------------------------------------
    //  Statistics Routes
    //-------------------------------------------------------------------------

        Route::prefix('statistics')->group(function() {

            // Fixed Function : Get Employees Nationality Count & Percentages
            Route::get('/boxes', [ReportsController::class, 'boxes']);

            // Fixed Function : Get Onleave People Lite Information
            Route::get('/onleave', [ReportsController::class, 'OnLeaveLite']);

            // Fixed Function : Get Anniversary People Lite Information
            Route::get('/anniversary', [ReportsController::class, 'AnniversaryLite']);    // Need to Fixed - Should Be Only People Above One Year

            // Fixed Function : Get Probation People Lite Information
            Route::get('/probation', [ReportsController::class, 'ProbationLite']);

            // Fixed Function : Get Probation People Lite Information
            Route::get('/birthday', [ReportsController::class, 'BirthdayLite']);

            // Fixed Function : Get Employees Nationality Count & Percentages
            Route::get('/nationality', [ReportsController::class, 'country']);

            // Fixed Function : Get Male/Female Percentage
            Route::get('/gender', [ReportsController::class, 'gender']);

            // Fixed Function : Get Company Employees Percentage
            Route::get('/company', [ReportsController::class, 'company']);

            // Fixed Function : Get Company Employees Percentage
            Route::get('/visa', [ReportsController::class, 'visa']);

            // Fixed Function : Deposit Count
            Route::get('/passport', [ReportsController::class, 'passport']);
        
        });

    //-------------------------------------------------------------------------
    //  Notes Routes
    //-------------------------------------------------------------------------

        Route::prefix('notes')->group(function() {

            // Fixed Function : Get A Note By Its ID
            Route::get('/{id}', [NotesController::class, 'show']);

            // Fixed Function : Get A Specific Employee Notes
            Route::get('/all', [NotesController::class, 'index']);

            // Fixed Function : Add Notes To Employees
            Route::post('/add', [NotesController::class, 'store']);

            // Fixed Function : Get A Specific Employee Notes
            Route::get('/employee/{id}', [NotesController::class, 'show']);

            // Fixed Function : Delete A Note By Its ID
            Route::delete('/delete/{id}', [NotesController::class, 'destroy'])->name('delete.note');

            // Fixed Function : Get Employees Nationality Count & Percentages
            Route::put('/update/{id}', [NotesController::class, 'update']);
        
        });

//=========================================================================
//  End Of Protected Routes
//=========================================================================

        // Employee Logout
        Route::post('/logout', [AuthController::class, 'logout']);  

    });     // Dont Touch Me
