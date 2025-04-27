<?php
namespace App\Http\Controllers\api\v1\Nurse;

use App\DTOs\NurseDto;
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
                with: ['clinic']
            ),
            resource: NurseResource::class
        );
    }

    public function show($id)
    {
        $nurse = $this->nurseService->find($id, ['clinic']);

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

    public function update(UpdateNurseRequest $request, $id)
    {
        $nurseDto = NurseDto::from($request->validated());
        $nurse    = $this->nurseService->update(
            $nurseDto,
            $this->nurseService->find($id)
        );

        return ApiResponse::success(
            message: 'Nurse updated successfully',
            data: new NurseResource($nurse)
        );
    }

    public function destroy($id)
    {
        $this->nurseService->delete($this->nurseService->find($id));

        return ApiResponse::success(
            message: 'Nurse deleted successfully'
        );
    }
}
