<?php

namespace App\Services;

use App\Models\Doctor;
use DoctorDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorService
{
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Doctor::paginate($perPage);
    }

    public function create(DoctorDto $doctorDto): Doctor
    {
        return Doctor::create($doctorDto->toArray());
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
}
