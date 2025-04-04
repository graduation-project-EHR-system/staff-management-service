<?php
namespace App\Services;

use App\Data\Clinic\ClinicDto;
use App\Models\Clinic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicService
{
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Clinic::paginate($perPage);
    }

    public function update(ClinicDto $clinicDto, Clinic $clinic): Clinic
    {
        $clinic->update($clinicDto->toArray());

        return $clinic->fresh();
    }

    public function create(ClinicDto $clinicDto): Clinic
    {
        return Clinic::create($clinicDto->toArray());
    }
}
