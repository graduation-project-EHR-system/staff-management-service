<?php

namespace App\Services;

use App\Data\Doctor\DoctorDto;
use App\Enums\StoragePath;
use App\Models\Doctor;
use App\Util\Storage\StorageManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Junges\Kafka\Facades\Kafka;

class DoctorService
{
    public function __construct(
        protected StorageManager $storageManager
    ) {}

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
        return Doctor::query()->create($doctorDto->toArray());
    }

    public function update(
        DoctorDto $doctorDto,
        Doctor $doctor
    ): Doctor {
        $doctor->update($doctorDto->toArray());

        return $doctor->fresh();
    }

    public function delete(Doctor $doctor): void
    {
        $doctor->delete();
    }

    public function publishDoctorCreatedMessage(Doctor $doctor): void
    {
        Kafka::publish()
            ->onTopic('doctor-created')
            ->withBody(json_encode($doctor))
            ->send();
    }
}
