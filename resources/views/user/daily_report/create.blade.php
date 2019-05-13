@extends ('common.user')
@section ('content')

<h2 class="brand-header">日報作成</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['daily_report.index'], 'method' => 'POST']) !!}
      {!! Form::hidden('user_id', Auth::id(), ['class' => 'form-control']) !!}
      <div class="form-group form-size-small {{ $errors->has('reporting_time') ? 'has-error text-danger' : '' }}">
        {!! Form::date('reporting_time', old('reporting_time') ? : Carbon::now(), ['class' => 'form-control']) !!}
        <span class="help-block">
            {{ $errors->first('reporting_time') }}
        </span>
      </div>
      <div class="form-group {{ $errors->has('title') ? 'has-error text-danger' : '' }}">
        {!! Form::text('title', old('title'), ['placeholder' => 'Title', 'class' => 'form-control']) !!}
        <span class="help-block">
          {{ $errors->first('title') }}
        </span>
      </div>
      <div class="form-group {{ $errors->has('contents') ? 'has-error text-danger' : '' }}">
        {!! Form::textarea('contents', old('contents'), ['placeholder' => 'Content', 'rows' => 10, 'cols' => 50,'class' => 'form-control']) !!}
        <span class="help-block">
            {{ $errors->first('contents') }}
        </span>
      </div>
      {!! Form::submit('ADD', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>
@endsection

