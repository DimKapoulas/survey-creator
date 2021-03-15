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
    public function index(Questionnaire $questionnaire)
    {
        $data = $questionnaire->questions()->get();
        
        return (new QuestionCollection($data))
                ->response()
                ->setStatuscode(200);
    }

    public function bulk(Questionnaire $questionnaire, Request $request) {
        $body = json_decode($request->getContent(), true);
        error_log('before loop');
        foreach($body as $entry) {
            error_log('start');
            error_log($entry);
            $title = $entry->question;
            error_log($title);
            $answers = $entry->answers;
            error_log($answers);
            error_log('end!');
        }
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
