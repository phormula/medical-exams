<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Structure extends Model
{
    use HasFactory, LogsActivity;
    protected $table = "structures";

    //insertable columns in database
    protected $fillable = ['user_id', 'name', 'phone', 'address', 'city_id'];

    protected static $logName = 'structure';

    protected static $recordEvents = ['created', 'updated'];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = ["IpAddress" => $_SERVER['REMOTE_ADDR']];
    }

    public $timestamps = false;
}
