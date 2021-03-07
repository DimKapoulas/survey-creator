<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // List all questions
    public function index()
    {
        return new QuestionCollection(Question::get());
    }


    // Storing a new question
    public function store(Questionnaire $questionnaire)
    {
        $data = $this->validateQuestion();
        $question =  $questionnaire->questions()->create($data);
        
        return (new QuestionResource($question))
                ->response()
                ->setStatusCode(201);
    }

    // Return detail about specific question and associated answers
    public function show(Questionnaire $questionnaire, Question $question)
    {
        $data = Question::with('answers')->get();
        
        return response()->json($data);
    }

    // Update a 


    public function destroy(Questionnaire $questionnaire, Question $question)
    {
        // First cascade delete on related answers
        // then delete the question itself
        $question->answers()->delete();
        $question->delete();

        return response()->json(null, 204);
    }


    // Validate input. Question is string and mandatory.
    protected function validateQuestion()
    {
        return request()->validate([
            'question' => 'required|string'
        ]);
    }
    
}
