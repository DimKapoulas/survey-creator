<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // Turn on mass assignment
    protected $fillable = ['answer', 'question_id'];

    // Relationships
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
