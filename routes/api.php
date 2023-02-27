<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;

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



Route::Post('/students', [studentController::class, 'store']);
Route::Get('/students', [studentController::class, 'GetStudents']);
Route::Get('/students/{id}', [studentController::class, 'GetStudentsById']);
Route::Delete('/students/{id}', [studentController::class, 'deletestudents']);
Route::Patch('/students/{id}', [studentController::class, 'editstudents']);



