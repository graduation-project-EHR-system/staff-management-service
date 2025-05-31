<?php
namespace App\Services;

use App\Data\Nurse\NurseDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Nurse;
use App\Repositories\NurseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NurseService
{
    public function __construct(
        protected EventPublisher $eventPublisher,
        protected NurseRepository $nurseRepository
    ) {}

    public function getAll(
        array $with = []
    ): Collection {
        return Nurse::with($with)->get();
    }

    public function getPaginated(
        int $perPage = 15,
        array $with = []
    ): LengthAwarePaginator {
        return $this->nurseRepository->getPaginated($perPage, $with);
    }

    public function getById(
        string $id,
        array $with = []
    ): Nurse {
        return $this->nurseRepository->getById($id, $with);
    }

    public function create(NurseDto $nurseDto): Nurse
    {
        $nurse = $this->nurseRepository->create($nurseDto);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_CREATED)
            ->withBody($this->constructEventBody($nurse))
            ->publish();

        return $nurse;
    }

    public function update(
        NurseDto $nurseDto,
        Nurse $nurse
    ): Nurse {
        $nurse = $this->nurseRepository->update($nurse, $nurseDto);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_UPDATED)
            ->withBody($this->constructEventBody($nurse))
            ->publish();

        return $nurse;
    }

    public function delete(Nurse $nurse): void
    {
        $this->nurseRepository->delete($nurse);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_DELETED)
            ->withBody($this->constructEventBody($nurse))
            ->publish();
    }

    protected function constructEventBody(Nurse $nurse): array
    {
        return [
            'id'        => $nurse->id,
            'firstName' => $nurse->first_name,
            'lastName'  => $nurse->last_name,
            'email'     => $nurse->email,
            'phone'     => $nurse->phone,
            'role'      => UserRole::NURSE->name,
        ];
    }
}
