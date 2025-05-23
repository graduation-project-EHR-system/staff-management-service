<?php
namespace App\Http\Controllers\api\v1\Receptionist;

use App\DTOs\ReceptionistDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceptionistRequest;
use App\Http\Requests\UpdateReceptionistRequest;
use App\Http\Resources\ReceptionistResource;
use App\Services\ReceptionistService;
use App\Util\ApiResponse;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    public function __construct(
        private readonly ReceptionistService $receptionistService
    ) {
    }

    public function index(Request $request)
    {
        return ApiResponse::success(
            message: 'Receptionists fetched successfully',
            data: $this->receptionistService->getPaginated(),
            resource: ReceptionistResource::class
        );
    }

    public function show($id)
    {
        $receptionist = $this->receptionistService->find($id);

        return ApiResponse::success(
            message: 'Receptionist fetched successfully',
            data: new ReceptionistResource($receptionist)
        );
    }

    public function store(StoreReceptionistRequest $request)
    {
        $receptionistDto = ReceptionistDto::from($request->validated());

        $receptionist = $this->receptionistService->create($receptionistDto);

        return ApiResponse::created(
            message: 'Receptionist created successfully',
            data: new ReceptionistResource($receptionist)
        );
    }

    public function update(UpdateReceptionistRequest $request, $id)
    {
        $receptionistDto = ReceptionistDto::from($request->validated());

        $receptionist    = $this->receptionistService->update(
            $this->receptionistService->find($id),
            $receptionistDto
        );

        return ApiResponse::success(
            message: 'Receptionist updated successfully',
            data: new ReceptionistResource($receptionist)
        );
    }

    public function destroy($id)
    {
        $this->receptionistService->delete(
            $this->receptionistService->find($id)
        );

        return ApiResponse::success(
            message: 'Receptionist deleted successfully'
        );
    }
}
