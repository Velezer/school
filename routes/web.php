<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
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



Route::group(["middleware" => "no.auth.jwt"], function () {
    Route::get('/web/signIn', function () {
        return view("signin"); // signin.blade.php
    });
    Route::get('/web/signUp', function () {
        return view("signup"); // signup.blade.php
    });
});

Route::group(["middleware" => "auth.jwt"], function () {
    Route::get('/web/signOut', [UserController::class, "signOut"])->name("webSignOut");

    Route::get('/web/dashboard/user/{id}', [UserController::class, "detailView"])->name("webUserDetail");
    Route::get('/web/dashboard/user/{id}/edit', [UserController::class, "editView"])->name("webUserEditView");

    // Route::get('/web/signUp', function () {
    //     return view("register");
    // });
    Route::get('/web/dashboard', [DashboardController::class, "dashboard"]);

    Route::group(["middleware" => "role.admin"], function () {
        Route::get('/web/dashboard/teacher/create', [UserController::class, "createView"]);
        Route::get('/web/dashboard/teacher/{id}/edit', [UserController::class, "editView"])->name("webTeacherEditView");

        Route::get('/web/dashboard/student/create', [UserController::class, "createView"]);
        Route::get('/web/dashboard/student/{id}/edit', [UserController::class, "editView"])->name("webStudentEditView");

        Route::get('/web/dashboard/period/create', [PeriodController::class, "createView"]);
        
        Route::get('/web/dashboard/subject/create', [SubjectController::class, "createView"])->name("webSubjectCreate");
        Route::get('/web/dashboard/subject/{id}/edit', [SubjectController::class, "editView"]);

        Route::get('/web/dashboard/timetable/create', [TimetableController::class, "createView"])->name('webTimetableCreate');
        Route::get('/web/dashboard/timetable/{id}/edit', [TimetableController::class, "editView"]);

    });
    
    Route::group(["middleware" => "role.admin.or.teacher"], function () {
        Route::get('/web/dashboard/assessment/create', [AssessmentController::class, "createView"])->name('webAssessmentCreate');
        Route::get('/web/dashboard/assessment/{id}/edit', [AssessmentController::class, "editView"]);
        
        Route::get('/web/dashboard/course/create', [CourseController::class, "createView"])->name('webCourseCreate');
        Route::get('/web/dashboard/course/{id}/edit', [CourseController::class, "editView"]);

        Route::get('/web/dashboard/report/create', [ReportController::class, "createView"])->name('webReportCreate');
        Route::get('/web/dashboard/report/{id}/edit', [ReportController::class, "editView"])->name('webReportUpdate');
        
        Route::get('/web/dashboard/teacher', [TeacherController::class, "listView"])->name("webTeacherListView");
        Route::get('/web/dashboard/teacher/{id}', [UserController::class, "detailView"]);
    });
    
    Route::group(["middleware" => "role.admin.or.student"], function () {
        Route::get('/web/dashboard/submission/create', [SubmissionController::class, "createView"])->name('webSubmissionCreate');
        Route::get('/web/dashboard/submission/{id}/edit', [SubmissionController::class, "editView"]);
    });


    Route::get('/web/dashboard/student', [StudentController::class, "listView"])->name("webStudentListView");
    Route::get('/web/dashboard/student/{id}', [UserController::class, "detailView"]);


    Route::get('/web/dashboard/classroom', [ClassroomController::class, "listView"]);

    Route::get('/web/dashboard/period', [PeriodController::class, "listView"]);

    Route::get('/web/dashboard/subject', [SubjectController::class, "listView"]);

    Route::get('/web/dashboard/timetable', [TimetableController::class, "listView"]);

    Route::get('/web/dashboard/assessment', [AssessmentController::class, "listView"]);

    Route::get('/web/dashboard/course', [CourseController::class, "listView"]);
    Route::get('/web/dashboard/course/{id}', [CourseController::class, "detailView"]);

    Route::get('/web/dashboard/submission', [SubmissionController::class, "listView"]);
    Route::get('/web/dashboard/submission/{id}', [SubmissionController::class, "detailView"]);

    Route::get('/web/dashboard/reports', [DashboardController::class, "dashboardReportDetail"]);

    Route::get('/web/dashboard/report', [ReportController::class, "listView"]);
    Route::get('/web/dashboard/report/{id}', [ReportController::class, "detailView"])->name('webReportDetail');
});


// Route::get('/', function () {
//     return view('register');
// });
// Route::get('/', function () {
//     return view('welcome');
// });
