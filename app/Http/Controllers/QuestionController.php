<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // List all questions and their corresponding answers
    public function index()
    {
        $data = Question::with('answers')->get();
        
        return (new QuestionCollection($data))
                ->response()
                ->setStatuscode(200);
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

    // Return detail about specific question
    public function show(Questionnaire $questionnaire, Question $question)
    {
        return new QuestionResource($question);
    }

    // Update a question
    public function update(Questionnaire $questionnaire, Question $question)
    {
        $this->validateQuestion();
        $question->update(request()->all());
        return (new QuestionResource($question))
                ->response()
                ->setStatusCode(200);
    }


    public function destroy(Questionnaire $questionnaire, Question $question)
    {
        // First cascade delete on related answers
        // then delete the question itself
        $question->answers()->delete();
        $question->delete();

        return response()->json(null, 204);
    }


    // Validate input or redirect
    protected function validateQuestion()
    {
        return request()->validate([
            'question' => 'required|string'
        ]);
    }
    
}
