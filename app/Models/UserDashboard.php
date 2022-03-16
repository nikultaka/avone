<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class UserDashboard extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'user_dashboards';
    public $timestamps = false;

    protected $fillable = [
        '_id','user_id','networkAssessmentFindings','severity','cve_cwe','cvss3','description','buisness_impact','published_exploit','recommendation','monitor_your_threat'
    ];
}
