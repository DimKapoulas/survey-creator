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
        // Init response array
        $data = [];

        // Get all surveys from most recent
        foreach(Questionnaire::orderBy('id','DESC')->get() as  $questionnaire) {
            // For each one of them fetch its questions
            $questions = $questionnaire->questions();
            // Pair them with their related answers
            $question_answer_pair = $questions->with('answers')->get();
            
            // Make a survey object
            $content = [
                'id' => $questionnaire->id,
                'title' => $questionnaire->title,
                'questions' => $question_answer_pair,
            ];

            // Store all surveys in one place
            $data[] = $content;

        }

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
        // Fetch its questions and their related answers
        $question = $questionnaire->questions() ;
        $question_answer_pair = $question->with('answers')->get();

        // Make response object out of them
        $data = [
            'id' => $questionnaire->id,
            'title' => $questionnaire->title,
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
