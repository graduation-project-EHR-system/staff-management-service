<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\Doctor\DoctorResource;
use App\Models\Doctor;
use App\Services\DoctorService;
use App\Util\ApiResponse;
use DoctorDto;

class DoctorController extends Controller
{
    public function __construct(
        protected DoctorService $doctorService
    ){}

    public function index()
    {
        return ApiResponse::success(
            data: $this->doctorService->getPaginated(),
            resource: DoctorResource::class
        );
    }

    public function store(StoreDoctorRequest $request)
    {
        $doctor = $this->doctorService->create(
            DoctorDto::fromRequest($request)
        );

        return ApiResponse::created(
            message: 'Doctor created successfully.',
            data: new DoctorResource($doctor),
        );
    }

    public function show(Doctor $doctor)
    {
        return ApiResponse::success(
            message: 'Doctor retrieved successfully',
            data: new DoctorResource($doctor)
        );
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $updatedDoctor = $this->doctorService->update(
            DoctorDto::fromRequest($request),
            $doctor
        );

        return ApiResponse::success(
            message: 'Doctor updated successfully',
            data: new DoctorResource($updatedDoctor)
        );
    }

    public function destroy(Doctor $doctor)
    {
        $this->doctorService->delete($doctor);

        return ApiResponse::success(
            message: 'Doctor deleted successfully',
        );
    }
}
