<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use App\Util\ApiResponse;
use Illuminate\Http\Request;

class GetAnalyticsController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ){}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $analytics = $this->analyticsService->getStaffAnalytics();

        return ApiResponse::send(
            data: [
                'num_of_doctors' => $analytics->numberOfDoctors,
                'num_of_nurses' => $analytics->numberOfNurses,
                'num_of_specializations' => $analytics->numberOfSpecializations,
                'num_of_receptionists'=> $analytics->numberOfReceptionists
            ]
        );
    }
}
