<?php
namespace App\Services;

use App\Data\Doctor\DoctorDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Doctor;
use App\Repositories\DoctorRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorService
{
    public function __construct(
        protected EventPublisher $eventPublisher,
        protected DoctorRepository $doctorRepository
    ) {}

    public function getPaginated(
        int $perPage = 15,
        array $with = []
    ): LengthAwarePaginator {
        return $this->doctorRepository->getPaginated($perPage, $with);
    }

    public function getById(
        string $id,
        array $with = []
    ): Doctor {
        return $this->doctorRepository->getById($id, $with);
    }

    public function create(DoctorDto $doctorDto): Doctor
    {
        $doctor = $this->doctorRepository->create($doctorDto);

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
        $doctor = $this->doctorRepository->update($doctor, $doctorDto);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_UPDATED)
            ->withBody($this->constructEventBody($doctor))
            ->publish();

        return $doctor;
    }

    public function delete(Doctor $doctor): void
    {
        $this->doctorRepository->delete($doctor);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_DELETED)
            ->withBody($this->constructEventBody($doctor))
            ->publish();
    }

    protected function constructEventBody(Doctor $doctor): array
    {
        return [
            'id'        => $doctor->id,
            'firstName' => $doctor->first_name,
            'lastName'  => $doctor->last_name,
            'email'     => $doctor->email,
            'phone'     => $doctor->phone,
            'role'      => UserRole::DOCTOR->name,
        ];
    }

    public function getLookup()
    {
        return $this->doctorRepository->getAll(['id', 'first_name', 'last_name']);
    }
}
