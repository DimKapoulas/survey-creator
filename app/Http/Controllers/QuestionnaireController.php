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
        
        // Init auxiliary arrays
        $survey = [];
        $data = [];
        $content = [];

        // For every questionnaire fetch its related questions
        foreach($questionnaires as $questionnaire) {
            $questions = $questionnaire->questions()->get();

            // For each of these questions, fetch its related answers
            foreach($questions as $question) {
                // Similar to "question A: ans1, ans2, ... etc"
                $question_answers_pair = $question->with('answers')
                                                   ->where('id','=',$question->id)
                                                   ->get();
                
                // Gather each pair
                $content[] = $question_answers_pair;
                
            }

            // Create survey
            $survey = [
                'id' => $questionnaire->id,
                'title' => $questionnaire->title,
                'questions' => $content,
                // 'questions' => $question_answers_pair
            ];
               
            // Gather each survey on same place.
            $data[] = $survey;
            reset($content);
                
        }

        // Return them as one object
        return response()->json($data, 200);

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
