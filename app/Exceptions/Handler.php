<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    // public function render($request, Throwable $e)
    // {
    //     if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
    //         return response()->json([
    //             'data' => [
    //                 'message' => 'Resource not found',
    //                 'status_code' => Response::HTTP_NOT_FOUND
    //             ]
    //         ], Response::HTTP_NOT_FOUND);
    //     } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
    //         return response()->json([
    //             'data' => [
    //                 'message' => 'Endpoint not found',
    //                 'status_code' => Response::HTTP_NOT_FOUND
    //             ]
    //         ], Response::HTTP_NOT_FOUND);
    //     }

    //     return response()->json([
    //         'data' => [
    //             'message' => $e->getMessage(),
    //             'status_code' => Response::HTTP_BAD_REQUEST
    //         ]
    //     ], Response::HTTP_BAD_REQUEST);
    // }
}
