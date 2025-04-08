<?php

namespace App\Http\Controllers\api\v1\Doctor\Availabilities;

use App\Data\DoctorAvailability\DoctorAvailabilityDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorAvailability\StoreDoctorAvailability;
use App\Http\Resources\Doctor\DoctorAvailabilityResource;
use App\Services\DoctorAvailabilityService;
use App\Services\DoctorService;
use App\Util\ApiResponse;

class DoctorAvailabilityController extends Controller
{
    public function __construct(
        private readonly DoctorAvailabilityService $doctorAvailabilityService,
        private readonly DoctorService $doctorService
    ) {
    }

    public function index(int $doctorId)
    {
        return ApiResponse::success(
            message: 'Doctor availabilities fetched successfully.',
            data: $this->doctorAvailabilityService->getForDoctorPaginated(
                $doctorId,
                'desc',
                ['clinic']
            ),
            resource: DoctorAvailabilityResource::class
        );
    }

    public function show(int $availabilityId)
    {
        return ApiResponse::success(
            message: 'Doctor availability fetched successfully.',
            data: new DoctorAvailabilityResource(
                $this->doctorAvailabilityService->getById($availabilityId)
            )
        );
    }

    public function store(int $doctorId, StoreDoctorAvailability $request)
    {
        $doctor = $this->doctorService->getById($doctorId);

        $doctorAvailabilityDto = DoctorAvailabilityDto::from($request->validated());

        $doctorAvailability = $this->doctorAvailabilityService->createForDoctor($doctorAvailabilityDto, $doctor);

        return ApiResponse::created(
            message: 'Doctor availability created successfully.',
            data: new DoctorAvailabilityResource($doctorAvailability)
        );
    }
}
