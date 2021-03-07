<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerCollection;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    // Get all answers
    public function indexAll()
    {
        return new AnswerCollection(Answer::get());
    }

    // Get answers related with specific question
    public function index(Question $question)
    {
        $answers = $question->answers()->get();
        return new AnswerCollection($answers);

    }

    // Save an answer
    public function store(Question $question)
    {
        $data = $this->validateAnswer();

        $answer = $question->answers()->create($data);
        return new AnswerResource($answer);
    }

    

    // Validate input. Question is string and mandatory.
    protected function validateAnswer()
    {
        return request()->validate([
            'answer' => 'required|string'
        ]);
    }
}
