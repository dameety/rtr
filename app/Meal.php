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

    public function scopeAvailable($query)
    {
        return $query->where('units', '>', 0);
    }

    public function reduceUnits()
    {
        $this->units = $this->units--;
        $this->save();
    }

}
