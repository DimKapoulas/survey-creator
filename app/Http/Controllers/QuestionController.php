<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Storing a new question
    public function store(Questionnaire $questionnaire)
    {
        $data = $this->validatedData();

        #TODO: figure how assign answers
        
    }


    // Validate input. Question is mandatory and string.
    protected function validatedData()
    {
        return request()->validate([
            'question' => 'required|string'
        ]);
    }
    
}
