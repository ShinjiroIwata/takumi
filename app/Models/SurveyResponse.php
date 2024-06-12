<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clinic_id',
        'line_id',
        'survey_type',
        'question_number',
        'answer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
