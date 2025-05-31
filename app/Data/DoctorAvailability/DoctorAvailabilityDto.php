<?php

namespace App\Data\DoctorAvailability;

use App\Models\Doctor;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class DoctorAvailabilityDto extends Data
{
    #[MapOutputName('clinic_id')]
    #[MapInputName('clinic_id')]
    public string $clinicId;

    #[MapOutputName('doctor_id')]
    #[MapInputName('doctor_id')]
    public string $doctorId;
    public string $date;
    public string $from;
    public string $to;
}
