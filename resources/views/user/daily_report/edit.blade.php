@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['daily_report.update', $report->id], 'method' => 'PATCH']) !!}
      {!! Form::hidden('user_id', Auth::user()->id, ['class' => 'form-control']) !!}
      <div class="form-group form-size-small {{ $errors->has('reporting_time') ? 'has-error text-danger':'' }}">
        {!! Form::date('reporting_time', old('reporting_time') ? : $report->reporting_time, ['class' => 'form-control $errors->has("reporting_time") ? "has-error text-danger" : ""']) !!}
        <span class="help-block">
          {{ $errors->first('reporting_time') }}
        </span>
      </div>
      <div class="form-group {{ $errors->has('title') ? 'has-error test-danger' : '' }}">
        {!! Form::text('title', old('title') ? : $report->title, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        <span class="help-block">
          {{ $errors->first('title') }}
        </span>
      </div>
      <div class="form-group {{ $errors->has('contents') ? 'has-error test-danger' : '' }}">
        {!! Form::textarea('contents', old('contents') ? : $report->contents, ['class' => 'form-control', 'placeholder' => 'Contents']) !!}
        <span class="help-block">
          {{ $errors->first('contents') }}
        </span>
      </div>
      {!! Form::submit('UPDATE', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

