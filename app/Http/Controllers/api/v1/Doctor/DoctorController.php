<?php
namespace App\Http\Controllers\api\v1\Doctor;

use App\Data\Doctor\DoctorDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\Doctor\DoctorResource;
use App\Models\Doctor;
use App\Services\DoctorService;
use App\Util\ApiResponse;
use Junges\Kafka\Facades\Kafka;

class DoctorController extends Controller
{
    public function __construct(
        protected DoctorService $doctorService
    ) {}

    public function index()
    {
        return ApiResponse::success(
            data: $this->doctorService->getPaginated(
                with: ['specialization'],
                filters: request()->all()
            ),
            resource: DoctorResource::class
        );
    }

    public function store(StoreDoctorRequest $request)
    {
        $doctor = $this->doctorService->create(
            DoctorDto::from($request->validated())
        );

        return ApiResponse::created(
            message: 'Doctor created successfully.',
            data: new DoctorResource($doctor->load('specialization')),
        );
    }

    public function show(string $id)
    {
        return ApiResponse::success(
            message: 'Doctor retrieved successfully',
            data: new DoctorResource(
                $this->doctorService->getById(
                    $id,
                    ['upcomingAvailabilities', 'upcomingAvailabilities.clinic', 'specialization']
                )
            )
        );
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $updatedDoctor = $this->doctorService->update(
            DoctorDto::from(
                array_merge(
                    $doctor->toArray(),
                    $request->validated()
                )
            ),
            $doctor
        );

        return ApiResponse::success(
            message: 'Doctor updated successfully',
            data: new DoctorResource($updatedDoctor->load('specialization'))
        );
    }

    public function destroy(string $id)
    {
        $this->doctorService->delete($this->doctorService->getById($id));

        return ApiResponse::success(
            message: 'Doctor deleted successfully',
        );
    }

    public function lookup()
    {
        return ApiResponse::success(
            data: $this->doctorService->getLookup()
        );
    }
}
