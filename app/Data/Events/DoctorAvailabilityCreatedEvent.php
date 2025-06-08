<?php

namespace App\Data\Events;

use App\Models\DoctorAvailability;

class DoctorAvailabilityCreatedEvent
{
    public function __construct(public DoctorAvailability $doctorAvailability) {}


    public function toArray(): array
    {
        return [
            'doctor_id' => $this->doctorAvailability->doctor_id,
            'availability_id' => $this->doctorAvailability->id,
            'clinic_id' => $this->doctorAvailability->clinic_id,
            'date' => $this->doctorAvailability->date,
            'from' => $this->doctorAvailability->from,
            'to' => $this->doctorAvailability->to,
        ];
    }
}
