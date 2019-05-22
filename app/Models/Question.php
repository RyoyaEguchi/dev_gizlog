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

    public function fetchQuestion($questionId)
    {
        return $this->find($questionId);
    }

    public function fetchQuestions($searchRequest)
    {
        if (!empty($searchRequest->search_word)) {
            if ($searchRequest->tag_category_id === '0') {
                return $this->fetchSearchByWord($searchRequest);
            } else {
                return $this->fetchSearchByTagAndWord($searchRequest);
            }
        } elseif ($searchRequest->tag_category_id !== '0') {
            return $this->fetchSearchByTag($searchRequest);
        } else {
            return $this->fetchAllQuestions();
        }
    }

    public function fetchSearchByTagAndWord($searchRequest)
    {
        return $this->with(['tagCategory', 'user'])
                    ->where('tag_category_id', $searchRequest->tag_category_id)
                    ->where('title', 'like', "%$searchRequest->search_word%")
                    ->withCount('comments')
                    ->get();
    }

    public function fetchAllQuestions()
    {
        return $this->with(['tagCategory', 'user'])
                    ->withCount('comments')
                    ->get();
    }

    public function fetchMyQuestions($authId)
    {
        return $this->where('user_id', $authId)
                    ->with('tagCategory')
                    ->withCount('comments')
                    ->get();
    }

    public function fetchSearchByTag($searchRequest)
    {
        return $this->with('tagCategory')
                    ->where('tag_category_id', $searchRequest->tag_category_id)
                    ->with('user')
                    ->withCount('comments')
                    ->get();
    }

    public function fetchSearchByWord($searchRequest)
    {
        return $this->join('tag_categories', 'questions.tag_category_id', '=', 'tag_categories.id')
                    ->where('title', 'like', "%$searchRequest->search_word%")
                    ->orWhere('name', $searchRequest->search_word)
                    ->with(['tagCategory', 'user'])
                    ->withCount('comments')
                    ->get();
    }

    public function fetchDetailesQuestion($questionId)
    {
        return $this->with(['tagCategory', 'user'])->find($questionId);
        
    }

    public function createQuestion($request)
    {
        return $this->create($request->all());
    }

    public function updateQuestion($request, $questionId)
    {
        return $this->find($questionId)->fill($request->all())->save();
    }

    public function destroyQuestion($questionId)
    {
        return $this->find($questionId)->delete();
    }
}
