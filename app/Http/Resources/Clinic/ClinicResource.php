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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'current_doctors' => $this->current_doctors,
            'max_doctors' => $this->max_doctors,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'doctors' => DoctorResource::collection($this->whenLoaded('doctors')),
        ];
    }
}
