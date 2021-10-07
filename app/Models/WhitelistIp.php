<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class WhitelistIp extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'whitelistIp';
    public $timestamps = false;

    protected $fillable = [
        '_id','ip_name','status','created_at','updated_at'
    ];
}
