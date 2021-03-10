<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Http\Resources\QuestionnaireCollection;
use App\Http\Resources\QuestionnaireResource;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    // Retrieve all questionnaires starting from latest
    public function index()
    {
        // $questionnaires = Questionnaire::orderBy('created_at', 'DESC')->get();
        $questionnaires = Questionnaire::all();
        // $questionnaires = Questionnaire::find(1);
        // echo gettype($questionnaires[0]->id);
        $survey = [];
        $data = [];
        $content = [];
        foreach($questionnaires as $questionnaire) {
            $questions = $questionnaire->questions()->get();
            // echo $questions;
            // echo "\n\n\n";
            // break;

            foreach($questions as $question) {
                // echo $question->question;
                echo "\n\n\n\n";
                
                $question_answers_pair = $question->with('answers')
                                                   ->where('id','=',$question->id)
                                                   ->get();
                // echo $pairs;
                // dd($pairs);
                $content[] = $question_answers_pair;
                
            }

            $survey = [
                'id' => $questionnaire->id,
                'title' => $questionnaire->title,
                'questions' => $content,
            ];
            
            // return;
               
            
            $data[] = $survey;
            reset($content);
                
                
                

            
            // echo gettype($questionnaire);
        echo "\n\n";
        

            // dd($data);
        }
        
        return response()->json($data, 200);
        // return $questionnaires;
        // return $questions;
    }

    // Store a new questionnaire
    public function store()
    {
        $data = $this->validateTitle();
        $questionnaire = Questionnaire::create($data);

        return (new QuestionnaireResource($questionnaire))
                ->response()
                ->setStatusCode(201);
    }

    // Show details of specific questionnaire as a whole
    public function show (Questionnaire $questionnaire)
    {       
        $question = $questionnaire->questions() ;
        $question_answer_pair = $question->with('answers')->get();
        $title = $questionnaire->title;
        $id = $questionnaire->id;

        $data = [
            'id' => $id,
            'title' => $title,
            'questions' => $question_answer_pair,
        ];

        return response()->json($data, 200);

    }

    public function update(Questionnaire $questionnaire)
    {
        $this->validateTitle();
        $questionnaire->update(request()->all());
        return (new QuestionnaireResource($questionnaire))
                ->response()
                ->setStatusCode(200);
    }


    // Delete a questionnaire and its related content
    public function destroy(Questionnaire $questionnaire)
    {

        // Cascade delete on related questions and answers
        $questionnaire->answers()->delete();
        $questionnaire->questions()->delete();
        $questionnaire->delete();

        return response()->json(null, 204);
    }


    // Validate or redirect
    protected function validateTitle()
    {
        return request()->validate([
            'title' => 'required|string'
        ]);
    }

}
