<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\Answer;
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
    // Upon survey creation, save questions and its related answers
    public function bulk(Questionnaire $questionnaire) {
        /* This roughly a hard coded work around to deal with
            a serious bug created in the front end. In essence
            I utilized eloquent methods in an unwrapped manner */
            
        $body =request()->getContent();
        // Decode string to array to loop over it
        foreach(json_decode($body) as $entry) {
            // Create empty model and populate its atributes
            $new_question = new Question;
            $new_question -> question = $entry-> question;
            $new_question -> questionnaire_id = $questionnaire-> id;
            // Same for answers
            $question_id = $questionnaire->questions()->save($new_question);
            foreach($entry->answers as $answer){
                $new_answer = new Answer;
                $new_answer-> answer = $answer-> answer;
                $new_answer-> question_id = $question_id; 
                $question_id->answers()->save($new_answer);
            }
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
        // Cascade delete on related answers then delete
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
