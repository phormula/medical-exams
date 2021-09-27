<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory, LogsActivity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = ["IpAddress" => request()->getClientIp()];
    }

    public function structures()
    {
        return $this->belongsToMany(Structure::class);
    }
}
