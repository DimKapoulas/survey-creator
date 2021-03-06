<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionnaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for indexing questionnaires
Route::get('/questionnaires', [QuestionnaireController::class, 'index']);

// Routing Group for questionnaire
Route::prefix('/questionnaire')->group( function () {
    Route::post('/store', [QuestionnaireController::class, 'store']);
    Route::get('/{questionnaire}', [QuestionnaireController::class, 'show']);
    Route::get('/{questionnaire}/edit', [QuestionnaireController::class, 'edit']);
    

});

// Routing Group for questions
Route::prefix('/questionnaire/{questionnaire}/question')->group( function () {
    Route::post('/store', [QuestionController::class, 'store']);
    Route::put('/{question}', [QuestionController::class, 'update']);

    
});


