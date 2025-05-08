<?php

use App\Http\Middleware\EnforeceJsonResponseForApiRequests;
use App\Util\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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

            Route::get('/test', function (Request $request) {
                $clientIp = $request->ip();
                $forwardedIp = $request->header('X-Forwarded-For');
                $realIp = $request->header('X-Real-IP');

                \Log::info('Client IP: ' . $clientIp);
                \Log::info('X-Forwarded-For: ' . ($forwardedIp ?: 'Not set'));
                \Log::info('X-Real-IP: ' . ($realIp ?: 'Not set'));

                return "Client IP: " . $clientIp .
                       "<br>X-Forwarded-For: " . ($forwardedIp ?: 'Not set') .
                       "<br>X-Real-IP: " . ($realIp ?: 'Not set');
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->append(
            EnforeceJsonResponseForApiRequests::class,
            \Rakutentech\LaravelRequestDocs\LaravelRequestDocsMiddleware::class,
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

        // $exceptions->renderable(function (Exception $e) {
        //     return ApiResponse::send(
        //         message: $e->getMessage(),
        //         code: is_int($e->getCode()) ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR
        //     );
        // });
    })->create();
