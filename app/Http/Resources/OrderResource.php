<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'cart' => json_decode($this->cart),
                'customer' => new UserResource($this->whenLoaded('customer')),
                'driver' => new UserResource($this->whenLoaded('driver'))
            ]
        );

    }
}
