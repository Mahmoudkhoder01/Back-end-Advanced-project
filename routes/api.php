<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\sectioncontroller;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\attendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;


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

//student routes
Route::Post('/students', [StudentController::class, 'store']);
Route::Get('/students', [StudentController::class, 'getStudents']);
Route::Get('/students/{id}', [StudentController::class, 'getStudent']);
Route::Delete('/students/{id}', [StudentController::class, 'deleteStudent']);
Route::Patch('/students/{id}', [StudentController::class, 'editStudent']);

//grade routes
Route::Post('/grade', [GradeController::class, 'addGrade']);
Route::Get('/grade', [GradeController::class, 'getGrades']);
Route::Get('/grade/{id}', [GradeController::class, 'getGrade']);
Route::Delete('/grade/{id}', [GradeController::class, 'deleteGrade']);
Route::Put('/grade/{id}', [GradeController::class, 'editGrade']);

//admin routes
Route::Get('/admin', [AdminController::class, 'getAll']);
Route::Get('/admin/{id}', [AdminController::class, 'getById']);
Route::Post('/admin', [AdminController::class, 'addAdmin']);
Route::Delete('/admin/{id}', [AdminController::class, 'deleteAdmin']);
Route::Patch('/admin/{id}', [AdminController::class, 'editAdmin']);
//section routes
Route::Post('/section', [sectioncontroller::class, 'addSection']);
Route::Get('/section/{id}', [sectioncontroller::class, 'getSection']);
Route::Get('/section', [sectioncontroller::class, 'getSections']);
Route::Delete('/section/{id}', [sectioncontroller::class, 'deleteSection']);
Route::Patch('/section/{id}', [sectioncontroller::class, 'editSection']);
//attendance routes
Route::Post('/attendance', [attendancecontroller::class, 'takeAttendance']);
Route::Get('/attendance', [attendancecontroller::class, 'getAll']);
Route::Get('/attendance/student/{student_id}', [attendancecontroller::class, 'getAttendanceByStudentId']);
Route::Get('/attendance/section/{section_id}', [attendancecontroller::class, 'getAttendanceBySectionId']);
Route::Delete('/attendance/{id}', [attendancecontroller::class, 'deleteAttendance']);
Route::Patch('/attendance/{id}', [attendancecontroller::class, 'editAttendance']);
Route::Get('/attendance/student/{student_id}/daterange', [attendancecontroller::class, 'getAttendanceByStudentIdAndDateRange']);


Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});