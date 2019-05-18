@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問編集</h1>

<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['question.update', $question->id], 'method' => 'patch']) !!}
      <div class="form-group {{ $errors->first('tag_category_id') ? 'has-error' : '' }}">
        {!! Form::hidden('user_id', Auth::id()) !!}
        {!! Form::select('tag_category_id', $tags, $question->tag_category_id,
          ['class' => 'form-control selectpicker form-size-smallz'])
        !!}
        <span class="help-block">{{ $errors->has('tag_category_id')}}</span>
      <div class="form-group {{ $errors->first('title') ? 'has-error' : '' }}">
        {!! Form::text('title', $question->title ? : old('title'), ['placeholder' => 'title', 'class' => 'form-control']) !!}
        <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group {{ $errors->first('content') ? 'has-error' : '' }}">
        {!! Form::textarea('content', $question->content ? : old('content'), 
          ['placeholder' => 'Please write down your question here...', 'class' => 'form-control']) 
        !!}
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      {!! Form::submit('UPDATE', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

