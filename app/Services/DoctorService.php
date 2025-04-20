<?php

namespace App\Services;

use App\Data\Doctor\DoctorDto;
use App\Enums\KafkaTopic;
use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Junges\Kafka\Facades\Kafka;

class DoctorService
{
    public function getPaginated(
        int $perPage = 15,
        array $with = []
    ): LengthAwarePaginator {
        return Doctor::with($with)->paginate($perPage);
    }

    public function getById(
        int $id,
        array $with = []
    ): Doctor {
        return Doctor::with($with)->findOrFail($id);
    }

    public function create(DoctorDto $doctorDto): Doctor
    {
        $doctor = Doctor::query()->create($doctorDto->toArray());

        Kafka::publish()
            ->onTopic(KafkaTopic::DOCTORS_CREATE->value)
            ->withBody(json_encode($doctor))
            ->send();

        return $doctor;
    }

    public function update(
        DoctorDto $doctorDto,
        Doctor $doctor
    ): Doctor {
        $doctor->update($doctorDto->toArray());

        Kafka::publish()
            ->onTopic(KafkaTopic::DOCTORS_UPDATE->value)
            ->withBody(json_encode($doctor))
            ->send();

        return $doctor->fresh();
    }

    public function delete(Doctor $doctor): void
    {
        $doctor->delete();

        Kafka::publish()
            ->onTopic(KafkaTopic::DOCTORS_DELETE->value)
            ->withBody(json_encode($doctor))
            ->send();
    }
}
