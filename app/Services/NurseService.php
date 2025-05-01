<?php
namespace App\Services;

use App\DTOs\NurseDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Nurse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NurseService
{
    public function __construct(
        protected EventPublisher $eventPublisher
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
        return Nurse::with($with)->paginate($perPage);
    }

    public function find(string $id, array $with = []): Nurse
    {
        return Nurse::with($with)->findOrFail($id);
    }

    public function create(NurseDto $nurseDto): Nurse
    {
        $nurse = Nurse::create($nurseDto->toArray());

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
        $nurse->update($nurseDto->toArray());

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_UPDATED)
            ->withBody($this->constructEventBody($nurse))
            ->publish();

        return $nurse->refresh();
    }

    public function delete(Nurse $nurse): void
    {
        $nurse->delete();

        $this->eventPublisher
            ->onTopic(KafkaTopic::USER_DELETED)
            ->withBody($this->constructEventBody($nurse))
            ->publish();

    }

    protected function constructEventBody(Nurse $nurse): array
    {
        return [
            'id' => $nurse->id,
            'first_name' => $nurse->first_name,
            'last_name' => $nurse->last_name,
            'email' => $nurse->email,
            'phone' => $nurse->phone,
            'type' => UserRole::NURSE->name,
        ];
    }
}
