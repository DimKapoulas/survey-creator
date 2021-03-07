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
        $data = $this->validatedData();
        $question =  $questionnaire->questions()->create($data);
        
        return new QuestionResource($question);
    }


    // Validate input. Question is string and mandatory.
    protected function validatedData()
    {
        return request()->validate([
            'question' => 'required|string'
        ]);
    }
    
}
