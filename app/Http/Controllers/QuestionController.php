<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Storing a new question
    public function store(Questionnaire $questionnaire)
    {
        $data = $this->validatedData();

        // dd($data);
        // dd($data['question']);
        // dd($questionnaire->questions()->create($data));
        // $question =  $questionnaire->questions()->create($data);
        // $data['questionnaire_id'] = $questionnaire->questions();
        $question = Question::create($data);
        dd(response()->json($data));

        // return response()->json($question, 201);

        #TODO: figure how assign answers
        
    }


    // Validate input. Question is string and mandatory.
    protected function validatedData()
    {
        return request()->validate([
            'question' => 'required|string'
        ]);
    }
    
}
