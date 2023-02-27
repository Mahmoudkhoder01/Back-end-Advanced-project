<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\sectioncontroller;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\attendanceController;
use App\Http\Controllers\AdminController;

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


Route::post('/students', [StudentController::class, 'store']);
Route::get('/students', [StudentController::class, 'getStudents']);
Route::Post('/grade', [GradeController::class, 'addGrade']);
Route::Get('/grade', [GradeController::class, 'getGrades']);
Route::Get('/grade/{id}', [GradeController::class, 'getGrade']);
Route::Delete('/grade/{id}', [GradeController::class, 'deleteGrade']);
Route::Put('/grade/{id}', [GradeController::class, 'editGrade']);


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

Route::Post('/attendance', [attendancecontroller::class, 'takeAttendance']);
Route::Get('/attendance/{id}', [attendancecontroller::class, 'getAttendance']);
Route::Get('/attendance', [attendancecontroller::class, 'getAttendance']);
Route::Delete('/attendance/{id}', [attendancecontroller::class, 'deleteAttendance']);
Route::Patch('/attendance/{id}', [attendancecontroller::class, 'editAttendance']);
