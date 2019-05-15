@extends ('common.user')
@section ('content')

<h2 class="brand-header">質問投稿</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['question.store', Auth::id()], 'method' => 'post']) !!}
      {!! Form::hidden('user_id', Auth::id()) !!}
      <div class="form-group {{ $errors->first('tag_category_id') ? 'has-error' : '' }}">
        {!! Form::select('tag_category_id', $tags, old('tag_cagetory_id'), ['placeholder' => 'Select Category', 'class' => 'form-control selectpicker form-size-small']) !!}
        <span class="help-block">{{ $errors->first('tag_category_id') }}</span>
      </div>
      <div class="form-group {{ $errors->first('title') ? 'has-error' : '' }}">
        {!! Form::text('title', old('title'), ['placeholder' => 'title', 'class' => 'form-control']) !!}
      <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group {{ $errors->first('content') ? 'has-error' : '' }}">
        {!! Form::textarea('content', old('content'), ['placeholder' => 'Please write down your question here...', 'class' => 'form-control']) !!}
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      {!! Form::submit('CREATE', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

