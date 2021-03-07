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

    // Show details of specific questionnaire
    public function show (Questionnaire $questionnaire)
    {        
        $question_answer_pair = Question::with('answers')->get();
        $title = $questionnaire->title;
        $id = $questionnaire->id;

        $data = [
            'id' => $id,
            'title' => $title,
            'questions' => $question_answer_pair,
        ];

        return response()->json($data, 200);

    }

    public function update(Request $request)
    {
        return $request->getContent();
    }


    // Delete a questionnaire and its related content
    public function destroy(Questionnaire $questionnaire)
    {

        // Cascade delete on related answers (with ManyThrough())
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
