<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    public function structures()
    {
        return $this->hasMany(Structure::class, 'city_id');
    }

    public function postCodes()
    {
        return $this->hasOne(PostalCode::class, 'city_id');
    }

}
