<?php

namespace Database\Seeders;

use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\Answer;

use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Questionnaire $questionnaire, Question $question, Answer $answer)
    {
        // Truncate all for fresh start from scratch
        Questionnaire::truncate();
        Question::truncate();
        Answer::truncate();
            
        // First survey
        $questionnaire  = Questionnaire::create([
            'title' => 'Covid-19'
        ]);
        // First question for first survey
        $question = $questionnaire->questions()->create([
            'question' => 'Did you suffer from the virus?'
        ]);
        // Related answers
        $question->answers()->create([
            'answer' => 'Yes'
        ]);
        $question->answers()->create([
            'answer' => 'No'
        ]);
        
        $question = $questionnaire->questions()->create([
            'question' => 'Do you believe the virus exists?'
        ]);

        $question->answers()->create([
            'answer' => 'Ofcourse!'
        ]);
        $question->answers()->create([
            'answer' => "It's all a lie!"
        ]);



        // Second survey
        $questionnaire = Questionnaire::create([
            'title' => 'PepperCode Review'
        ]);
        $question = $questionnaire->questions()->create([
            'question' => 'How woud your rate Peppercode?'
        ]);
        $question->answers()->create([
            'answer' => 'Excellent'
        ]);
        $question->answers()->create([
            'answer' => 'Mediocre'
        ]);
        $question->answers()->create([
            'answer' => 'Awful'
        ]);



    }
}
