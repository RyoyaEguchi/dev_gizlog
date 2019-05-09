<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Http\Requests\User\DailyReportRequest;

class DailyReportController extends Controller
{
    private $daily_report;

    public function __construct(DailyReport $instanceClass)
    {
        $this->middleware('auth');

        $this->daily_report = $instanceClass;
    }
    public function index()
    {
        return view('user.daily_report.index');
    }

    public function create()
    {
        return view('user.daily_report.create');
    }

    public function store(DailyReportRequest $request)
    {
        $this->daily_report->create($request->validated());
        return redirect()->route('daily_report.index');
    }
}