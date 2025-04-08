<?php

use App\Http\Middleware\EnforeceJsonResponseForApiRequests;
use App\Util\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function(){
            Route::prefix('api/v1')
                ->middleware('api')
                ->group(base_path('routes/v1/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->append(
            EnforeceJsonResponseForApiRequests::class
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return ApiResponse::send(
                    code: Response::HTTP_NOT_FOUND,
                    message: 'Model not found.'
                );
            }
        });

        $exceptions->renderable(function (Exception $e) {
            return ApiResponse::send(
                message: $e->getMessage(),
                code: is_int($e->getCode()) ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        });
    })->create();
