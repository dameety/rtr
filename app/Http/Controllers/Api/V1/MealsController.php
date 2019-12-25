<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealCreateRequest;
use App\Http\Requests\MealUpdateRequest;
use App\Http\Resources\MealCollection;
use App\Http\Resources\MealResource;
use App\Meal;
use Illuminate\Http\Request;

class MealsController extends Controller
{
    public function index()
    {
        $meals = Meal::where('units', '>', 0)->paginate(10);

        return $this->sendResponse([
            'meals' => new MealCollection($meals)
        ], 'Meals retrieved successfully.');
    }

    public function store(MealCreateRequest $request)
    {
        $meal = Meal::create($request->only(['name', 'description', 'price', 'units']));

        return $this->sendResponse([
            'meal' => new MealResource($meal)
        ], 'Meal successfully created');
    }

    public function show(Meal $meal)
    {
        return $this->sendResponse([
            'meal' => new MealResource($meal)
        ], 'Meal successfully retrieved.');
    }

    public function update(MealUpdateRequest $request, Meal $meal)
    {
        $meal->update($request->only(['description', 'price', 'units']));

        return $this->sendResponse([
            'meal' => new MealResource($meal->refresh())
        ], 'Meal successfully updated.');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();

        return $this->sendResponse([], 'Meal successfully deleted.');
    }
}
