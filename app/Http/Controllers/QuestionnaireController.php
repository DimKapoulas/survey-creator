<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Http\Resources\QuestionnaireCollection;
use App\Http\Resources\QuestionnaireResource;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    // Retrieve all existing questionnaires
    public function index()
    {
        return new QuestionnaireCollection(Questionnaire::all());

    }

    // Store a new questionnaire
    public function store()
    {
        $data = $this->validatedData();
        $questionnaire = Questionnaire::create($data);

        return (new QuestionnaireResource($questionnaire))
                ->response()
                ->setStatusCode(201);
    }

    // Validate user input. Title is mandatory and string.
    protected function validatedData()
    {
        return request()->validate([
            'title' => 'required|string'
        ]);
    }

}
