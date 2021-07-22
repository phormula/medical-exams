<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructureExam extends Model
{
    use HasFactory;
    protected $fillable = ['structure_id', 'exam_id'];
}
