<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
	protected $collection = 'cms';
    public $timestamps = false;

	protected $fillable = [
        'title','slug ','descriptioneditor','metatitle','metakeyword','metadescription','status','created_at','updated_at'
    ];
}
