<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class Settings extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'settings';
    public $timestamps = false;

    protected $fillable = [
        '_id','ecapikey','version','created_at','updated_at'
    ];
}
