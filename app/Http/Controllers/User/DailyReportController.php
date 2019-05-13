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
    protected $daily_report;

    public function __construct(DailyReport $instanceClass)
    {
        $this->middleware('auth');
        $this->daily_report = $instanceClass;
    }

    public function index(Request $request)
    {
        if(!is_null($this->daily_report)) {
            if(!is_null($request->query('search-month'))) {
                $date = new Carbon($request->query('search-month'));
                $reports = $this->daily_report->fetchSearchingDailyReports($date);
            } else {
                $reports = $this->daily_report->fetchDailyReports();
            }
        }
        return view('user.daily_report.index', compact('reports'));
    }

    public function create()
    {
        return view('user.daily_report.create');
    }

    public function show($DailyReportId)
    {
        $report = $this->daily_report->find($DailyReportId);
        return view('user.daily_report.show', compact('report'));
    }

    public function store(DailyReportRequest $request)
    {
        $this->daily_report->create($request->all());
        return redirect()->route('daily_report.index');
    }

    public function edit($DailyReportId)
    {
        $report = $this->daily_report->find($DailyReportId);
        return view('user.daily_report.edit', compact('report'));
    }

    public function update(DailyReportRequest $request, $DailyReportId)
    {
        $this->daily_report->find($DailyReportId)->fill($request->all())->save();
        return redirect()->route('daily_report.index');
    }

    public function delete($DailyReportId)
    {
        $report = $this->daily_report->find($DailyReportId)->delete();
        return redirect()->route('daily_report.index');
    }
}