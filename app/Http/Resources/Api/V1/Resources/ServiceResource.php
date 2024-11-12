<?php

namespace App\Http\Resources\Api\V1\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'academy_id' => $this->academy_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price
        ];
    }
}
