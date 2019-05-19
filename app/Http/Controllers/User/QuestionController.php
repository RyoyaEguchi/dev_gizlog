<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TagCategory;
use App\Http\Requests\User\QuestionsRequest;
use App\Models\Comment;
use App\Models\User;
use App\Http\Requests\User\CommentRequest;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    protected $question;
    protected $tag;
    protected $comment;

    public function __construct(Question $question, TagCategory $tag, Comment $comment)
    {
        $this->middleware('auth');
        $this->question = $question; 
        $this->tag = $tag;
        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $searchRequest)
    {
        $questions = $this->question->fetchQuestions($searchRequest);
        $tags = $this->tag->fetchAllTags();
        
        return view('user.question.index', compact('questions', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = $this->tag->fetchSelectTags();
        
        return view('user.question.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        $this->question->createQuestion($request);

        return redirect()->route('question.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($questionId)
    {
        $question = $this->question->fetchDetailesQuestion($questionId);
        $comments = $this->comment->fetchQuestionComments($questionId);
        
        return view('user.question.show', compact('question', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($questionId)
    {
        $question = $this->question->fetchQuestion($questionId);
        $tags = $this->tag->fetchSelectTags();
        
        return view('user.question.edit', compact('question', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionsRequest $request, $questionId)
    {
        $this->question->updateQuestion($request, $questionId);
        
        return redirect()->route('question.mypage', Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($questionId)
    {
        $this->question->destroyQuestion($questionId);

        return redirect()->route('question.mypage', Auth::id());
    }

    public function storeComment(CommentRequest $request)
    {
        $this->comment->createComment($request);

        return redirect()->route('question.show', $request->question_id);
    }

    public function showMypage($authId)
    {
        $questions = $this->question->fetchMyQuestions($authId);

        return view('user.question.mypage', compact('questions'));
    }
}
