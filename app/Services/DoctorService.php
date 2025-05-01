<?php

namespace App\Services;

use App\Data\Doctor\DoctorDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorService
{
    public function __construct(
        protected EventPublisher $eventPublisher
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
        $doctor = Doctor::query()->create($doctorDto->toArray());

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_CREATED)
            ->withBody($this->constructEventBody($doctor))
            ->publish();

        return $doctor;
    }

    public function update(
        DoctorDto $doctorDto,
        Doctor $doctor
    ): Doctor {
        $doctor->update($doctorDto->toArray());

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_UPDATED)
            ->withBody($this->constructEventBody($doctor))
            ->publish();

        return $doctor->fresh();
    }

    public function delete(Doctor $doctor): void
    {
        $doctor->delete();

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_DELETED)
            ->withBody($this->constructEventBody($doctor))
            ->publish();
    }

    protected function constructEventBody(Doctor $doctor): array
    {
        return [
            'id' => $doctor->id,
            'first_name' => $doctor->first_name,
            'last_name' => $doctor->last_name,
            'email' => $doctor->email,
            'phone' => $doctor->phone,
            'type' => UserRole::DOCTOR->name,
        ];
    }
}
