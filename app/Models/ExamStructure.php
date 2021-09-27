<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamStructure extends Model
{
    use HasFactory, LogsActivity;

    protected $table = "exam_structure";

    protected $fillable = ['structure_id', 'exam_id'];

    public $timestamps = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = ["IpAddress" => request()->getClientIp()];
    }
}
