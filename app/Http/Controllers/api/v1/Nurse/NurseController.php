<?php
namespace App\Http\Controllers\api\v1\Nurse;

use App\Data\Nurse\NurseDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNurseRequest;
use App\Http\Requests\UpdateNurseRequest;
use App\Http\Resources\NurseResource;
use App\Services\NurseService;
use App\Util\ApiResponse;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    protected $nurseService;

    public function __construct(NurseService $nurseService)
    {
        $this->nurseService = $nurseService;
    }

    public function index(Request $request)
    {
        return ApiResponse::success(
            message: 'Nurses fetched successfully',
            data: $this->nurseService->getPaginated(
                with: ['clinic'],
                filters: $request->all()
            ),
            resource: NurseResource::class
        );
    }

    public function show(string $id)
    {
        $nurse = $this->nurseService->getById($id, ['clinic']);

        return ApiResponse::success(
            message: 'Nurse fetched successfully',
            data: new NurseResource($nurse)
        );
    }

    public function store(StoreNurseRequest $request)
    {
        $nurseDto = NurseDto::from($request->validated());
        $nurse    = $this->nurseService->create($nurseDto);

        return ApiResponse::created(
            message: 'Nurse created successfully',
            data: new NurseResource($nurse)
        );
    }

    public function update(UpdateNurseRequest $request, string $id)
    {
        $nurseDto = NurseDto::from($request->validated());
        $nurse    = $this->nurseService->update(
            $nurseDto,
            $this->nurseService->getById($id)
        );

        return ApiResponse::success(
            message: 'Nurse updated successfully',
            data: new NurseResource($nurse)
        );
    }

    public function destroy(string $id)
    {
        $this->nurseService->delete($this->nurseService->getById($id));

        return ApiResponse::success(
            message: 'Nurse deleted successfully'
        );
    }
}
