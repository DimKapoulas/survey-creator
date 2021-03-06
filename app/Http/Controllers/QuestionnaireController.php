<?php

namespace App\Http\Controllers;

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
        $data = $this->validatedData();
        $questionnaire = Questionnaire::create($data);

        return (new QuestionnaireResource($questionnaire))
                ->response()
                ->setStatusCode(201);
    }

    // Show detail of specific questionnaire
    public function show (Questionnaire $questionnaire)
    {
        return new QuestionnaireResource($questionnaire);
    }

    // Validate input. Title is a string and mandatory
    protected function validatedData()
    {
        return request()->validate([
            'title' => 'required|string'
        ]);
    }

}
