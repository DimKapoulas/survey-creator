<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Http\Resources\QuestionnaireCollection;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    // Retrieve all existing questionnaires
    public function index()
    {
        return new QuestionnaireCollection(Questionnaire::all());

    }

    // Create a new questionnaire
    public function create()
    {
        // TODO: make a create view form vue.js
        return 'Hello from inside create()';
    }
}
