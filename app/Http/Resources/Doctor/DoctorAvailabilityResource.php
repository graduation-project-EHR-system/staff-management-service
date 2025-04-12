<?php

namespace App\Http\Resources\Doctor;

use App\Http\Resources\Clinic\ClinicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorAvailabilityResource extends JsonResource
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
            'date' => $this->resource->date,
            'from' => $this->resource->from,
            'to' => $this->resource->to,
            'clinic' => new ClinicResource($this->whenLoaded('clinic')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
