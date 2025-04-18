<?php

namespace App\Http\Controllers\api\v1\Clinic;

use App\Data\Clinic\ClinicDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clinic\StoreClinicRequest;
use App\Http\Requests\Clinic\UpdateClinicRequest;
use App\Http\Resources\Clinic\ClinicResource;
use App\Models\Clinic;
use App\Services\ClinicService;
use App\Util\ApiResponse;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function __construct(
        protected ClinicService $clinicService
    ) {}

    public function index(Request $request)
    {
        return ApiResponse::success(
            message: 'Clinics returned successfully',
            data: $this->clinicService->getPaginated(),
            resource: ClinicResource::class
        );
    }

    public function show(Clinic $clinic)
    {
        return ApiResponse::success(
            message: 'Clinic returned successfully',
            data: new ClinicResource($clinic->load('doctors')),
        );
    }

    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        $updatedClinic = $this->clinicService->update(
            ClinicDto::from(
                array_merge(
                    $clinic->toArray(),
                    $request->validated()
                )
            ),
            $clinic
        );

        return ApiResponse::success(
            message: 'Clinic updated successfully',
            data: new ClinicResource($updatedClinic)
        );
    }

    public function store(StoreClinicRequest $request)
    {
        $clinic = $this->clinicService->create(ClinicDto::from($request->validated()));

        return ApiResponse::created(
            message: 'Clinic created successfully',
            data: new ClinicResource($clinic),
        );
    }

    public function destroy(Clinic $clinic)
    {
        $this->clinicService->delete($clinic);

        return ApiResponse::success(message: 'Clinic deleted successfully');
    }
}
