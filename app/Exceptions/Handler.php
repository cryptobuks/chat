<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Chatter\Exceptions\ApiValidationException;
use App\Chatter\Exceptions\ApiUnauthenticatedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Chatter\Exceptions\DefaultException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Api handleable exceptions
     *
     * @var array
     */
    protected $apiExceptions = [
        AuthenticationException::class => ApiUnauthenticatedException::class,
        ValidationException::class => ApiValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
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
        if ($request->is('api*')) {
            $this->renderApi($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle Exception Thrown in API
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     */
    protected function renderApi($request, Exception $exception)
    {
        if (array_key_exists(get_class($exception), $this->apiExceptions)) {
            $apiException = $this->apiExceptions[get_class($exception)];

            throw new $apiException($exception);
        }

        if (! in_array(get_class($exception), $this->apiExceptions) and ! is_a($exception, DefaultException::class)) {
            // dd($exception);
            throw new DefaultException($exception);
        }
    }
}
