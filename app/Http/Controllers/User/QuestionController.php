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
        if ($request->tag_category_id === '0') {
            $questions = $this->question->all();
        } elseif (!is_null($request->tag_category_id)) {
            $questions = $this->question->where('tag_category_id', $this->tag->where('name', $request->tag_category_id)->pluck('id'))->get();
        } elseif (!is_null($request->search_word)) {
            $questions = $this->question->where('title', 'like', "%$request->search_word%")->get();
        } else {
            $questions = $this->question->all();
        }
        $tags = $this->tag->all();
        $comments = $this->comment->all();
        $avatar = $this->user->pluck('avatar', 'id');
        
        return view('user.question.index', compact('questions', 'tags', 'comments', 'avatar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = $this->tag->pluck('name', 'id');
        
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
        $this->question->create($request->all());

        return redirect()->route('question.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->question->find($id);
        $questionUser = $this->user->find($question->user_id);
        $tag = $this->tag->find($question->tag_category_id);

        $comments = $this->comment->where('question_id', $question->id)->get();
        
        $users = $this->user->all();
        // foreach ($comments as $comment) {
        //     $commentUsers .= $this->user->where('id', $comment->user_id)->get();
        // }
        
        return view('user.question.show', compact('question', 'questionUser', 'tag', 'comments', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeComment(CommentRequest $comment)
    {
        $this->comment->create($comment->all());

        return redirect()->route('question.show', $comment->question_id);
    }

    public function mypage()
    {
        return view('user.question.mypage');
    }
}
