<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;


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
Route::Post('/grade',[GradeController::class,'addGrade']);
Route::Get('/grade',[GradeController::class,'getGrades']);
Route::Get('/grade/{id}',[GradeController::class,'getGrade']);
Route::Delete('/grade/{id}',[GradeController::class,'deleteGrade']);
Route::Put('/grade/{id}',[GradeController::class,'editGrade']);
