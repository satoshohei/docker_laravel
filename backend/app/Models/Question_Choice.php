<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//論理削除に必要
use Illuminate\Database\Eloquent\SoftDeletes;

class Question_Choice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'question_id',
        'choice',
        'is_true_choice',
    ];
 
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
 
}
