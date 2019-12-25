<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MealCollection extends ResourceCollection
{
    private $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'per_page' => $resource->perPage(),
            'last_page' => $resource->lastPage(),
            'first' => $resource->url(1),
            'next' => $resource->nextPageUrl(),
            'current_page' => $resource->currentPage(),
            'prev' => $resource->previousPageUrl(),
            'last' => $resource->url($resource->lastPage())
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => MealResource::collection($this->collection),
            'pagination' => $this->pagination
        ];
    }
}
