<?php

namespace App\Observers;

use App\Meal;
use Illuminate\Support\Facades\Cache;

class MealObserver
{
    /**
     * Handle the meal "created" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function created(Meal $meal)
    {
        Cache::forget('all_meals');
    }

    /**
     * Handle the meal "updated" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function updated(Meal $meal)
    {
        Cache::forget('all_meals');
    }

    /**
     * Handle the meal "deleted" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function deleted(Meal $meal)
    {
        Cache::forget('all_meals');
    }

    /**
     * Handle the meal "restored" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function restored(Meal $meal)
    {
        //
    }

    /**
     * Handle the meal "force deleted" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function forceDeleted(Meal $meal)
    {
        //
    }
}
