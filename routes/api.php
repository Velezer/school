<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/api/signIn', [UserController::class, "signIn"])->name("/api/signIn");
// Route::post('/api/signUp', [UserController::class, "signUp"])->name("/api/signUp");


Route::group(["middleware" => "auth.jwt"], function () {
    Route::group(["middleware" => "role.admin"], function () {
        Route::post('/api/user/', [UserController::class, "create"])->name("apiCreateUser");
        Route::put('/api/user/{id}', [UserController::class, "update"])->name("apiUpdateUser");

        Route::delete('/api/teacher/{id}', [TeacherController::class, "delete"])->name("apiDeleteTeacher");

        Route::delete('/api/student/{id}', [StudentController::class, "delete"])->name("apiDeleteStudent");

        Route::post('/api/period', [PeriodController::class, "create"])->name("apiCreatePeriod");
        Route::delete('/api/period', [PeriodController::class, "delete"])->name("apiDeletePeriod");

        Route::post('/api/subject', [SubjectController::class, "create"])->name("apiCreateSubject");
        Route::put('/api/subject/{id}', [SubjectController::class, "update"])->name("apiUpdateSubject");
        Route::delete('/api/subject/{id}', [SubjectController::class, "delete"])->name("apiDeleteSubject");

        Route::post('/api/timetable', [TimetableController::class, "create"])->name("apiCreateTimetable");
        Route::put('/api/timetable/{id}', [TimetableController::class, "update"])->name("apiUpdateTimetable");
        Route::delete('/api/timetable/{id}', [TimetableController::class, "delete"])->name("apiDeleteTimetable");
    });

    Route::group(["middleware" => "role.admin.or.teacher"], function () {
        Route::post('/api/assessment', [AssessmentController::class, "create"])->name("apiCreateAssessment");
        Route::put('/api/assessment/{id}', [AssessmentController::class, "update"])->name("apiUpdateAssessment");
        Route::delete('/api/assessment/{id}', [AssessmentController::class, "delete"])->name("apiDeleteAssessment");

        Route::post('/api/course', [CourseController::class, "create"])->name("apiCreateCourse");
        Route::put('/api/course/{id}', [CourseController::class, "update"])->name("apiUpdateCourse");
        Route::delete('/api/course/{id}', [CourseController::class, "delete"])->name("apiDeleteCourse");

        Route::post('/api/report', [ReportController::class, "create"])->name("apiCreateReport");
        Route::put('/api/report/{id}', [ReportController::class, "update"])->name("apiUpdateReport");
        Route::delete('/api/report/{id}', [ReportController::class, "delete"])->name("apiDeleteReport");
    });

    Route::group(["middleware" => "role.admin.or.student"], function () {
        Route::post('/api/submission', [SubmissionController::class, "create"])->name("apiCreateSubmission");
        Route::delete('/api/submission/{id}', [SubmissionController::class, "delete"])->name("apiDeleteSubmission");
    });
});
