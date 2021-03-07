<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerCollection;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
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

        return (new AnswerResource($answer))
                    ->response()
                    ->setStatusCode(201);
    }

    public function show(Question $question, Answer $answer)
    {
        return new AnswerResource($answer);
    }

    public function update(Question $question, Answer $answer)
    {
    
        $answer->update(request()->all());
        return (new AnswerResource($answer))
                ->response()
                ->setStatusCode(200);
    }

    // Delete a specific answer
    public function destroy(Question $question, Answer $answer)
    {
        $answer->delete();
        
        return response()->json(null, 204);
    }


    // Validate input. Question is string and mandatory.
    protected function validateAnswer()
    {
        return request()->validate([
            'answer' => 'required|string'
        ]);
    }
}
