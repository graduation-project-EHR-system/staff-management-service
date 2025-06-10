<?php
namespace App\Http\Controllers\api\v1\Receptionist;

use App\Data\Receptionist\ReceptionistDto;
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
            data: $this->receptionistService->getPaginated(
                filters: $request->all()
            ),
            resource: ReceptionistResource::class
        );
    }

    public function show(string $id)
    {
        $receptionist = $this->receptionistService->getById($id);

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

    public function update(UpdateReceptionistRequest $request, string $id)
    {
        $receptionistDto = ReceptionistDto::from($request->validated());

        $receptionist    = $this->receptionistService->update(
            $receptionistDto,
            $this->receptionistService->getById($id)
        );

        return ApiResponse::success(
            message: 'Receptionist updated successfully',
            data: new ReceptionistResource($receptionist)
        );
    }

    public function destroy(string $id)
    {
        $this->receptionistService->delete(
            $this->receptionistService->getById($id)
        );

        return ApiResponse::success(
            message: 'Receptionist deleted successfully'
        );
    }
}
