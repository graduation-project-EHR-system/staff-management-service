<?php

namespace App\Http\Resources\Clinic;

use App\Http\Resources\Doctor\DoctorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'current_doctors' => $this->resource->current_doctors,
            'max_doctors' => $this->resource->max_doctors,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'doctors' => DoctorResource::collection($this->whenLoaded('doctors')),
        ];
    }
}
