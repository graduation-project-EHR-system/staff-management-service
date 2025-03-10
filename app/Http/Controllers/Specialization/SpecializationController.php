<?php

namespace App\Http\Controllers\Specialization;

use App\Http\Requests\Specialization\UpdateSpecializationRequest;
use App\Util\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Http\Controllers\Controller;
use App\Http\Requests\Specialization\StoreSpecializationRequest;
use App\Http\Resources\Specialization\SpecializationResource;

class SpecializationController extends Controller
{
    public function index()
    {
        return ApiResponse::success(
            'Specializations retrieved successfully',
            Specialization::paginate(),
            SpecializationResource::class
        );
    }

    public function store(StoreSpecializationRequest $request)
    {
        $specialization = Specialization::create($request->validated());

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
        $specialization->update($request->validated());

        return ApiResponse::success(
            message: 'Specialization updated successfully',
            data: new SpecializationResource($specialization->fresh())
        );
    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();

        return ApiResponse::success(
            message: 'Specialization deleted successfully'
        );
    }
}
