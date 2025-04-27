<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceptionistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name'  => $this->resource->last_name,
            'email'      => $this->resource->email,
            'phone'      => $this->resource->phone,
            'is_active'  => $this->resource->is_active,
            'created_at' => $this->resource->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
