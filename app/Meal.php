<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'name', 'price', 'units', 'description'
    ];

    protected $casts = [
        'price' => 'integer'
    ];

}
