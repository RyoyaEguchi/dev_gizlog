@extends ('common.user')
@section ('content')

<h2 class="brand-header">日報一覧</h2>
<div class="main-wrap">
  <div class="btn-wrapper daily-report">
  {!! Form::open(['method' => 'get']) !!}
    {!! Form::month('search-month', null, ['class' => 'form-control']) !!}
    {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-icon']) !!}
  {!! Form::close() !!}
  {{-- <form>
    @csrf
    <input class="form-control" name="search-month" type="month">
    <button type="submit" class="btn btn-icon"><i class="fa fa-search"></i></button>
  </form> --}}
    <a class="btn btn-icon" href="{{ route('daily_report.create') }}"><i class="fa fa-plus"></i></a>
  </div>
  <div class="content-wrapper table-responsive">
    <table class="table table-striped">
      <thead>
        <tr class="row">
          <th class="col-xs-2">Date</th>
          <th class="col-xs-3">Title</th>
          <th class="col-xs-5">Content</th>
          <th class="col-xs-2"></th>
        </tr>
      </thead>
      <tbody>
      @if (isset($reports))
      @foreach ($reports as $report)
        <tr class="row">
          <td class="col-xs-2">{{ date('m/d (D)',  strtotime($report->reporting_time)) }}</td>
          <td class="col-xs-3">{{ $report->title }}</td>
          <td class="col-xs-5">{{ $report->contents }}</td>
          <td class="col-xs-2"><a class="btn" href="{{ route('daily_report.show', $report->id) }}"><i class="fa fa-book"></i></a></td>
        </tr>
      @endforeach
      @endif
      </tbody>
    </table>
    @if (!isset($reports) || empty($reports->all()))
    <div class="text-danger">
      <p>日報がありません。</p>
    </div>
    @endif
  </div>
</div>

@endsection

