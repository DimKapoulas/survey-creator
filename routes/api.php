<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Resources\AnswerCollection;
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
// Route::get('/questionnaires', [QuestionnaireController::class, 'index']);

// Routing Group for questionnaire
Route::prefix('/questionnaires')->group( function () {
    Route::get('/', [QuestionnaireController::class, 'index']);
    Route::post('/store', [QuestionnaireController::class, 'store']);
    Route::get('/{questionnaire}', [QuestionnaireController::class, 'show']);
    Route::delete('/{questionnaire}', [QuestionnaireController::class, 'destroy']);
    

});

// Routing Group for questions
Route::prefix('/questionnaires/{questionnaire}/questions')->group( function () {
    Route::get('/', [QuestionController::class, 'index']);
    Route::post('/store', [QuestionController::class, 'store']);
    Route::get('/{question}', [Question::class, 'show']);
    Route::put('/{question}', [QuestionController::class, 'update']);
    Route::delete('/{question}', [QuestionController::class, 'destroy']);

});

// Testing route for listin ALL answers. TODO: delete this when done
Route::get('/answers', [AnswerController::class, 'indexAll']);

// Routing Group for answers
Route::prefix('/questions/{question}/answers')->group( function () {
    Route::get('/', [AnswerController::class, 'index']);
    Route::post('/store', [AnswerController::class, 'store']);
    Route::delete('/{answer}', [AnswerController::class, 'destroy']);

});
