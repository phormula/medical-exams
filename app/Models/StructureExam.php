<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StructureExam extends Model
{
    use HasFactory, LogsActivity;

    protected $table = "structure_exams";

    protected $fillable = ['structure_id', 'exam_id'];

    public $timestamps = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = ["IpAddress" => request()->getClientIp()];
    }
}
