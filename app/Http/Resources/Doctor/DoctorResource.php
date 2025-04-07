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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_picture' => $this->profile_picture_url,
            'specialization' => new SpecializationResource($this->whenLoaded('specialization')),
            'availabilities' => DoctorAvailabilityResource::collection($this->whenLoaded('upcomingAvailabilities')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
