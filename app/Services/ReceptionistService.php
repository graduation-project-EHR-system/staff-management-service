<?php
namespace App\Services;

use App\DTOs\ReceptionistDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Receptionist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ReceptionistService
{
    public function __construct(
        protected EventPublisher $eventPublisher
    ) {}

    public function getAll(array $with = []): Collection
    {
        return Receptionist::with($with)->get();
    }

    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return Receptionist::with($with)->paginate($perPage);
    }

    public function find(string $id, array $with = [])
    {
        return Receptionist::with($with)->findOrFail($id);
    }

    public function create(ReceptionistDto $receptionistDto): Receptionist
    {
        $receptionist = Receptionist::create($receptionistDto->toArray());

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_CREATED)
            ->withBody($this->constructEventBody($receptionist))
            ->publish();

        return $receptionist;
    }
    public function update(Receptionist $receptionist, ReceptionistDto $receptionistDto): Receptionist
    {
        $receptionist->update($receptionistDto->toArray());

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_UPDATED)
            ->withBody($this->constructEventBody($receptionist))
            ->publish();

        return $receptionist;
    }

    public function delete(Receptionist $receptionist)
    {
        $receptionist->delete();

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_DELETED)
            ->withBody($this->constructEventBody($receptionist))
            ->publish();
    }

    protected function constructEventBody(Receptionist $receptionist): array
    {
        return [
            'id' => $receptionist->id,
            'firstName' => $receptionist->first_name,
            'lastName' => $receptionist->last_name,
            'email' => $receptionist->email,
            'phone' => $receptionist->phone,
            'type' => UserRole::RECEPTIONIST->name,
        ];
    }
}
