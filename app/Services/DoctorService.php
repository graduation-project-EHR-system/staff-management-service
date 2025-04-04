<?php

namespace App\Services;

use App\Enums\StoragePath;
use App\Models\Doctor;
use App\Util\Storage\StorageManager;
use DoctorDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorService
{
    public function __construct(
        protected StorageManager $storageManager
    ){}

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Doctor::with('schedules')->paginate($perPage);
    }

    public function create(DoctorDto $doctorDto): Doctor
    {
        if ($doctorDto->profilePicture){
            $doctorDto->profilePicturePath = $this->storageManager->store(
                $doctorDto->profilePicture,
                StoragePath::DOCTOR_PROFILE_PICTURES
            );
        }

        return Doctor::create($doctorDto->toArray());
    }

    public function update(
        DoctorDto $doctorDto,
        Doctor $doctor
    ): Doctor {

        if ($doctorDto->profilePicture){
            $this->storageManager->delete(
                $doctor->profile_picture_path,
                StoragePath::DOCTOR_PROFILE_PICTURES
            );

            $doctorDto->profilePicturePath = $this->storageManager->store(
                $doctorDto->profilePicture,
                StoragePath::DOCTOR_PROFILE_PICTURES
            );
        }

        $doctor->update($doctorDto->toArray());

        return $doctor->fresh();
    }

    public function delete(Doctor $doctor): void
    {
        $this->storageManager->delete(
            $doctor->profile_picture_path,
            StoragePath::DOCTOR_PROFILE_PICTURES
        );

        $doctor->delete();
    }
}
