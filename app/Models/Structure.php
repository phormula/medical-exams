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
    protected $fillable = ['user_id', 'city_id', 'name', 'phone', 'address', 'premium'];

    protected static $logName = 'structure';

    protected static $recordEvents = ['created', 'updated'];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = ["IpAddress" => request()->getClientIp()];
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'structure_exams');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->hasOne(Cities::class, 'city_id');
    }
}
