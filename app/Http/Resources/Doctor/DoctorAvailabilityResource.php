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
            'id' => $this->id,
            'date' => $this->date,
            'from' => $this->from,
            'to' => $this->to,
            'clinic' => new ClinicResource($this->whenLoaded('clinic')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
