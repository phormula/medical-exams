<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;
    protected $table = "structures";

    protected $fillable = ['user_id', 'name', 'phone', 'address', 'city_id'];

    public $timestamps = false;
}
