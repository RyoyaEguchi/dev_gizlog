@extends ('common.user')
@section ('content')

<h2 class="brand-header">質問投稿</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => 'question.store', 'method' => 'post']) !!}
      <div class="form-group">
        {!! Form::select('tag_category_id', [], 'Select Category', ['class' => 'form-control selectpicker form-size-small']) !!}
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        {!! Form::text('title', old('title'), ['placeholder' => 'title', 'class' => 'form-control']) !!}
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        {!! Form::textarea('content', old('title'), ['placeholder' => 'Please write down your question here...', 'class' => 'form-control']) !!}
        <span class="help-block"></span>
      </div>
      {!! Form::submit('CREATE', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

