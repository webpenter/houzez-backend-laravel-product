<?php

namespace App\Http\Resources\Demos\Demo01\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FloorPlanDemo01Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
