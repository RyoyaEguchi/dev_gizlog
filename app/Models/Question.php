<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tag_category_id',
        'title',
        'content',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tagCategory()
    {
        return $this->belongsTo(TagCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fetchQuestion($question_id)
    {
        return $this->find($question_id);
    }

    public function fetchQuestions($request)
    {
        if ($request->tag_category_id === '0') {
            return $this->fetchAllQuestions();
        } elseif (!is_null($request->tag_category_id)) {
            return $this->fetchSearchByTag($request);
        } elseif (!is_null($request->search_word)) {
            return $this->fetchSearchByWord($request);
        } else {
            return $this->fetchAllQuestions();
        }
    }

    public function fetchAllQuestions()
    {
        return $this->with(['tagCategory', 'user'])
                    ->withCount('comments')
                    ->get();
    }

    public function fetchMyQuestions($auth_id)
    {
        return $this->where('user_id', $auth_id)
                    ->with('tagCategory')
                    ->withCount('comments')
                    ->get();
    }

    public function fetchSearchByTag($request)
    {
        return $this->with('tagCategory')
                    ->where('tag_category_id', $request->tag_category_id)
                    ->with('user')
                    ->withCount('comments')
                    ->get();
    }

    public function fetchSearchByWord($request)
    {
        return $this->join('tag_categories', 'questions.tag_category_id', '=', 'tag_categories.id')
                    ->where('title', 'like', "%$request->search_word%")
                    ->orWhere('name', $request->search_word)
                    ->with(['tagCategory', 'user'])
                    ->withCount('comments')
                    ->get();
    }

    public function createQuestion($request)
    {
        return $this->create($request->all());
    }

    public function updateQuestion($request, $question_id)
    {
        return $this->find($question_id)->fill($request->all())->save();
    }

    public function destroyQuestion($question_id)
    {
        return $this->find($question_id)->delete();
    }

    public function fetchDetailesQuestion($question_id)
    {
        return $this->with(['tagCategory', 'user'])->find($question_id);
        
    }
}

