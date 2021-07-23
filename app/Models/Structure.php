<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Structure extends Model
{
    use HasFactory, LogsActivity;
    protected $table = "structures";

    //insertable columns in database
    protected $fillable = ['user_id', 'name', 'phone', 'address', 'city_id'];

    protected static $logName = 'structure';

    public $timestamps = false;
}
