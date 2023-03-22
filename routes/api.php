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
Route::get('/students/section/{section_id}/pagination', [StudentController::class, 'getStudentBySectionIdByPagination']);
Route::get('/students/attendance/section/{section_id}/pagination', [StudentController::class, 'getStudentBySectionIdByPaginationInAttendance']);
Route::get('/students/pagination', [StudentController::class, 'getStudentsByPagination']);
Route::Get('student/attendance', [StudentController::class, 'getStudents_Attendance']);
Route::Get('/students/{id}', [StudentController::class, 'getStudent']);
Route::Get('/student_section/{id}', [StudentController::class, 'getStudentbySection']);
Route::Delete('/students/{id}', [StudentController::class, 'deleteStudent']);
Route::Patch('/students/{id}', [StudentController::class, 'editStudent']);
Route::get('/students/section/{section_id}', [StudentController::class, 'getStudentBySectionId']);

//grade routes
Route::Post('/grade', [GradeController::class, 'addGrade']);
Route::Get('/grade', [GradeController::class, 'getGrades']);
Route::Get('/grade/pagination', [GradeController::class, 'getGradesByPagination']);
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
Route::Get('/section/pagination', [sectioncontroller::class, 'getSectionsByPagination']);
Route::Get('/section/{grade}/pagination', [sectioncontroller::class, 'getSectionsByGradeIdByPagination']);
Route::Get('/section/{id}', [sectioncontroller::class, 'getSection']);
Route::Get('/section/grade/{grade_id}', [sectioncontroller::class, 'getSectionByGradeId']);
Route::Get('/section', [sectioncontroller::class, 'getSections']);
Route::Delete('/section/{id}', [sectioncontroller::class, 'deleteSection']);
Route::Patch('/section/{id}', [sectioncontroller::class, 'editSection']);
//attendance routes
Route::Post('/attendance', [attendancecontroller::class, 'takeAttendance']);
Route::Post('/attendanceforAll', [attendancecontroller::class, 'takeAttendanceforAll']);
Route::Get('/attendance', [attendancecontroller::class, 'getAll']);
Route::Get('/attendance/{date}', [attendancecontroller::class, 'getAttendanceByDate']);
Route::Get('/attendance/student/{student_id}', [attendancecontroller::class, 'getAttendanceByStudentId']);
Route::Get('/attendance/section/{section_id}', [attendancecontroller::class, 'getAttendanceBySectionId']);
Route::Get('/attendance/bydate&section/{section_id}/{attendance_date}', [attendancecontroller::class, 'getAttendanceBySectionIdAndDate']);
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
    Route::get('/user/pagination', [AuthController::class, 'getAllUsersByPaginate']);

    Route::patch('/edit/{id}', [AuthController::class, 'editUser']);
    Route::delete('/delete/{id}', [AuthController::class, 'deleteUser']);
});
Route::get('/user', [AuthController::class, 'getAll']);
