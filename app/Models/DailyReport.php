<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use SoftDeletes;

    protected $table = 'daily_reports';
    protected $dates = ['delete_at'];
    
    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'reporting_time',
    ];
}
