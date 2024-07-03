<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;

Route::post('/class', [ClassController::class, 'store']);
Route::get('/class', [ClassController::class, 'index']);
Route::get('/class/page/{page?}', [ClassController::class, 'paginate']);
Route::get('/class/{id}', [ClassController::class, 'show']);
Route::put('/class/{id}', [ClassController::class, 'update']);
Route::delete('/class/{id}', [ClassController::class, 'destroy']);
Route::post('/class/copy/{id}', [ClassController::class, 'copy']);
Route::post('/class/copy', [ClassController::class, 'copyMultiple']);
Route::post('/class/import', [ClassController::class, 'import']);
Route::get('/class/export', [ClassController::class, 'export']);

Route::post('/student', [StudentController::class, 'store']);
Route::get('/student', [StudentController::class, 'index']);
Route::get('/student/page/{page?}', [StudentController::class, 'paginate']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::put('/student/{id}', [StudentController::class, 'update']);
Route::delete('/student/{id}', [StudentController::class, 'destroy']);
Route::post('/student/copy/{id}', [StudentController::class, 'copy']);
Route::post('/student/copy', [StudentController::class, 'copyMultiple']);
Route::post('/student/import', [StudentController::class, 'import']);
Route::get('/student/export', [StudentController::class, 'export']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
