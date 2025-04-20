<?php

namespace App\Http\Resources\Doctor;

use App\Http\Resources\Specialization\SpecializationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'specialization' => new SpecializationResource($this->whenLoaded('specialization')),
            'availabilities' => DoctorAvailabilityResource::collection($this->whenLoaded('upcomingAvailabilities')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
