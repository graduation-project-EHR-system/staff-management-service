<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Util\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Data\Auth\AuthUser;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app(AuthUser::class)->role !== UserRole::ADMIN) {
            return ApiResponse::send(
                code: Response::HTTP_FORBIDDEN,
                message: 'You do not have permission to access this resource.',
            );
        }

        return $next($request);
    }
}
