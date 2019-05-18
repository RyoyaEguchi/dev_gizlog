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
    protected $user;

    public function __construct(Question $question, TagCategory $tag, Comment $comment, User $user)
    {
        $this->middleware('auth');
        $this->question = $question; 
        $this->tag = $tag;
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = $this->question->fetchQuestions($request);
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
    public function show($question_id)
    {
        $question = $this->question->fetchDetailesQuestion($question_id);
        $comments = $this->comment->fetchQuestionComments($question_id);
        // dd($question);
        return view('user.question.show', compact('question', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($question_id)
    {
        $question = $this->question->fetchQuestion($question_id);
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
    public function update(QuestionsRequest $request, $question_id)
    {
        $this->question->updateQuestion($request, $question_id);
        
        return redirect()->route('question.mypage', Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($question_id)
    {
        $this->question->find($question_id)->delete();

        return redirect()->route('question.mypage', Auth::id());
    }

    public function storeComment(CommentRequest $comment)
    {
        $this->comment->createComment($comment);

        return redirect()->route('question.show', $comment->question_id);
    }

    public function showMypage($auth_id)
    {
        $questions = $this->question->fetchMyQuestions($auth_id);
        $user = $this->user->fetchAuthUser($auth_id);

        return view('user.question.mypage', compact('questions', 'user'));
    }
}
