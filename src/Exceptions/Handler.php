<?php

namespace Damnyan\Cmn\Exceptions;

use Exception;
use Damnyan\Cmn\Facades\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ResourceNotFoundException) {
            return ApiResponse::resourceNotFound(
                trans_choice(
                    'cmn::messages.resource.empty',
                    1,
                    ['resource' => $exception->resource]
                )
            );
        } elseif ($exception instanceof NoResourceFoundException) {
            return ApiResponse::resourceNotFound(
                trans_choice(
                    'cmn::messages.resource.empty',
                    2,
                    ['resource' => $exception->resource]
                )
            );
        } elseif ($exception instanceof ForbiddenException) {
            return ApiResponse::forbidden(trans('cmn::messages.forbidden'));
        } elseif ($exception instanceof UnprocessedEntityException) {
            return ApiResponse::unproccessedEntity($exception->errors);
        } elseif ($exception instanceof BadRequestException) {
            return ApiResponse::badRequest($exception->message);
        } elseif ($exception instanceof QueryException && config('app.env') == 'production') {
            return ApiResponse::internalServerError(1013);
        } elseif ($exception instanceof ModelNotFoundException) {
            $model = $exception->getModel();
            return ApiResponse::resourceNotFound((new $model)->getResourceName().' not found.');
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
