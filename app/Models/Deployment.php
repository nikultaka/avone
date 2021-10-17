<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'deployments';
    public $timestamps = false;

    protected $fillable = [
        '_id','deploymentID','deploymentName','sizePerZoneElastic','availabilityZonesElastic','sizePerZoneKibana','availabilityZonesKibana','sizePerZoneApm','availabilityZonesApm','status','created_at','updated_at'
    ];
}
 