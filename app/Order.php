<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'address', 'cart', 'total_amount', 'driver_id'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public static function forUser($user)
    {
        if($user->isAdmin()) {
            return self::with(['customer', 'driver'])->paginate(10);
        }

        if($user->isDriver()) {
            return self::where('driver_id', $user->id)
                ->with(['customer', 'driver'])->paginate(10);
        }

        return self::where('user_id', $user->id)
                ->with(['customer', 'driver'])->paginate(10);
    }
}
