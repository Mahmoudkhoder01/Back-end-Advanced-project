<?php

use App\Http\Controllers\gradecontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sectioncontroller;
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
Route::Post('/grade', [gradecontroller::class, 'addGrade']);
Route::Post('/section', [sectioncontroller::class, 'addSection']);
Route::Get('/section/{id}', [sectioncontroller::class, 'getSection']);
Route::Get('/section', [sectioncontroller::class, 'getSections']);
Route::Delete('/section/{id}', [sectioncontroller::class, 'deleteSection']);
Route::Patch('/section/{id}', [sectioncontroller::class, 'editSection']);
