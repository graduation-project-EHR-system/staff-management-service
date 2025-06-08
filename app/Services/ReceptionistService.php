<?php
namespace App\Services;

use App\Data\Receptionist\ReceptionistDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Receptionist;
use App\Repositories\ReceptionistRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ReceptionistService
{
    public function __construct(
        protected EventPublisher $eventPublisher,
        protected ReceptionistRepository $receptionistRepository
    ) {}

    public function getAll(array $with = []): Collection
    {
        return Receptionist::with($with)->get();
    }

    public function getPaginated(
        int $perPage = 15,
        array $with = []
    ): LengthAwarePaginator {
        return $this->receptionistRepository->getPaginated($perPage, $with);
    }

    public function getById(
        string $id,
        array $with = []
    ): Receptionist {
        return $this->receptionistRepository->getById($id, $with);
    }

    public function create(ReceptionistDto $receptionistDto): Receptionist
    {
        $receptionist = $this->receptionistRepository->create($receptionistDto);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_CREATED)
            ->withBody($this->constructEventBody($receptionist))
            ->publish();

        return $receptionist;
    }

    public function update(
        ReceptionistDto $receptionistDto,
        Receptionist $receptionist
    ): Receptionist {
        $receptionist = $this->receptionistRepository->update($receptionist, $receptionistDto);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_UPDATED)
            ->withBody($this->constructEventBody($receptionist))
            ->publish();

        return $receptionist;
    }

    public function delete(Receptionist $receptionist): void
    {
        $this->receptionistRepository->delete($receptionist);

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_DELETED)
            ->withBody($this->constructEventBody($receptionist))
            ->publish();
    }

    protected function constructEventBody(Receptionist $receptionist): array
    {
        return [
            'id'        => $receptionist->id,
            'nationalId' => $receptionist->national_id,
            'firstName' => $receptionist->first_name,
            'lastName'  => $receptionist->last_name,
            'email'     => $receptionist->email,
            'phone'     => $receptionist->phone,
            'role'      => UserRole::RECEPTIONIST->name,
        ];
    }
}
