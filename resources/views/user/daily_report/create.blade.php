@extends ('common.user')
@section ('content')

<h2 class="brand-header">日報作成</h2>
<div class="main-wrap">
  <div class="container">
    <form action="{{ route('daily_report.index') }}" method="post">
      @csrf
      <input class="form-control" name="user_id" type="hidden" value="{{ Auth::user()->id }}">
      @if ($errors->has('reporting_time'))
        <div class="form-group form-size-small has-error text-danger">
          <input class="form-control"  name="reporting_time"  type="date" value="{{ old('reporting_time') }}">
          <span class="help-block"></span>
          {{ $errors->first('reporting_time') }}
        </div>
      @else
        <div class="form-group form-size-small">
          <input class="form-control"  name="reporting_time"  type="date" value="{{ old('reporting_time') }}">
          <span class="help-block"></span>
        </div>
      @endif
      @if ($errors->has('title'))
        <div class="form-group has-error text-danger">
          <input class="form-control" placeholder="Title" name="title" type="text" value="{{ old('title') }}">
          <span class="help-block"></span>
          {{ $errors->first('title') }}
        </div>
      @else
        <div class="form-group">
          <input class="form-control" placeholder="Title" name="title" type="text" value="{{ old('title') }}">
          <span class="help-block"></span>
        </div>
      @endif
      @if ($errors->has('contents'))
        <div class="form-group has-error text-danger">
          <textarea class="form-control" placeholder="Content" name="contents" cols="50" rows="10">{{ old('contents') }}</textarea>
          <span class="help-block"></span>
          {{ $errors->first('contents') }}
        </div>
      @else
        <div class="form-group">
          <textarea class="form-control" placeholder="Content" name="contents" cols="50" rows="10">{{ old('contents') }}</textarea>
          <span class="help-block"></span>
        </div>
      @endif
      <button type="submit" class="btn btn-success pull-right">Add</button>
    </form>
  </div>
</div>

@endsection

