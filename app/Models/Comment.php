<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'comment',
        'deleted_at'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createComment($request)
    {
        $this->create($request->all());
    }

    public function fetchQuestionComments($id)
    {
        return $this->where('question_id', $id)->with('user')->get();
    }
}