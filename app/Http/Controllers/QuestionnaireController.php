<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Http\Resources\QuestionnaireCollection;
use App\Http\Resources\QuestionnaireResource;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    // Retrieve all questionnaires starting from latest
    public function index()
    {
        $questionnaires = Questionnaire::orderBy('created_at', 'DESC')->get();
        return new QuestionnaireCollection($questionnaires);

    }

    // Store a new questionnaire
    public function store()
    {
        $data = $this->validateQuestionnaire();
        $questionnaire = Questionnaire::create($data);

        return (new QuestionnaireResource($questionnaire))
                ->response()
                ->setStatusCode(201);
    }

    // Show detail of specific questionnaire
    public function show (Questionnaire $questionnaire)
    {        
        
        return new QuestionnaireResource($questionnaire);
        
        
        /**Second approach 
            fetch everythin from questinons and answers
            and put them together in a single object 
        
        $questions = $questionnaire->questions()->get();
        $questions_list = [];

        // Iterate questions, grab question text
        for($i=0; $i < count($questions); $i++) {
            array_push($questions_list, $questions[$i]->question);
        }
        
        // Same for answers
            #TODO: fetch ansers into an array

        $details = [
            'title' => $questionnaire->title,
            'questions' => $questions_list,
        ];
        
        return new QuestionnaireResource($details);
        */
    }

    // Delete a questionnaire and its related content
    public function destroy(Questionnaire $questionnaire)
    {

        // First cascade delete on related answers
        // then on related the questions
        // then itself
        $questionnaire->answers()->delete();
        $questionnaire->questions()->delete();
        $questionnaire->delete();

        return response()->json(null, 204);
    }




    // Validate input. Title is a string and mandatory
    protected function validateQuestionnaire()
    {
        return request()->validate([
            'title' => 'required|string'
        ]);
    }

}
