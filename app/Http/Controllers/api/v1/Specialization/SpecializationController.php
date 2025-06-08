<?php
namespace App\Http\Controllers\api\v1\Specialization;


use App\Data\Specialization\SpecializationDto;
use App\Http\Requests\Specialization\UpdateSpecializationRequest;
use App\Services\SpecializationService;
use App\Util\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Http\Controllers\Controller;
use App\Http\Requests\Specialization\StoreSpecializationRequest;
use App\Http\Resources\Specialization\SpecializationResource;

class SpecializationController extends Controller
{
    public function __construct(
        protected SpecializationService $specializationService
    ){}

    public function index()
    {
        return ApiResponse::success(
            'Specializations retrieved successfully',
            $this->specializationService->getPaginated(
                filters : request()->all()
            ),
            SpecializationResource::class
        );
    }

    public function store(StoreSpecializationRequest $request)
    {
        $specialization = $this->specializationService->create(
            SpecializationDto::from(
                $request->validated()
            )
        );

        return ApiResponse::success(
            message: 'Specialization created successfully',
            data: new SpecializationResource($specialization)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
        return ApiResponse::success(
            message: 'Specialization retrieved successfully',
            data: new SpecializationResource($specialization)
        );
    }

    public function update(UpdateSpecializationRequest $request, Specialization $specialization)
    {
        $specialization = $this->specializationService->update(
            SpecializationDto::from(
                array_merge(
                    $specialization->toArray(),
                    $request->validated(),
                )
            ),
            $specialization
        );

        return ApiResponse::success(
            message: 'Specialization updated successfully',
            data: new SpecializationResource($specialization)
        );
    }

    public function destroy(Specialization $specialization)
    {
        $this->specializationService->delete($specialization);

        return ApiResponse::success(
            message: 'Specialization deleted successfully'
        );
    }
}
