<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\SearchingScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class DailyReport extends Model
{
    use SoftDeletes, SearchingScope;

    protected $table = 'daily_reports';
    protected $dates = ['delete_at'];
    
    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'reporting_time',
    ];

    public function fetchSearchingDailyReports($date)
    {
        return $this->where('user_id', Auth::id())
                    ->whereYear('reporting_time', $date->year)
                    ->whereMonth('reporting_time', $date->month)
                    ->latest('reporting_time')
                    ->get();
    }
}
