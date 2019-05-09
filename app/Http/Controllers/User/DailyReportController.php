<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Http\Requests\User\DailyReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyReportController extends Controller
{
    private $daily_report;

    public function __construct(DailyReport $instanceClass)
    {
        $this->middleware('auth');

        $this->daily_report = $instanceClass;
    }

    public function index(Request $request)
    {
        if(!is_null($this->daily_report) && !is_null($request->query('search-month'))) {
            $date = new Carbon($request->query('search-month'));
            $reports = $this->daily_report->where('user_id', '=', Auth::user()->id)->whereYear('reporting_time', '=', $date->year)->whereMonth('reporting_time', '=', $date->month)->latest('reporting_time')->get();
            return view('user.daily_report.index', compact('reports'));
        } else if(!is_null($this->daily_report)) {
            $reports = $this->daily_report->where('user_id', '=', Auth::user()->id)->latest('reporting_time')->get();
            return view('user.daily_report.index', compact('reports'));
        } else {
            return view('user.daily_report.index');
        }
    }

    public function create()
    {
        return view('user.daily_report.create');
    }

    public function show()
    {
        return view('user.daily_report.show');
    }

    public function store(DailyReportRequest $request)
    {
        $this->daily_report->create($request->validated());
        return redirect()->route('daily_report.index');
    }

    public function edit($DailyReportId)
    {
        $report = $this->daily_report->find($DailyReportId);
        return view('user.daily_report.edit', compact('report'));
    }

    public function update(DailyReportRequest $request, $DailyReportId)
    {
        $input = $request->all();
        $this->daily_report->find($DailyReportId)->fill($request->validated())->save();
        return redirect()->route('daily_report.index');
    }
}