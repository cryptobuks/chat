<?php

namespace App\Chatter\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

class DefaultException extends Exception implements Responsable
{
    /**
     * @var Exception
     */
    protected $exception;

    /**
     * @param Exception $exception
     */
    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        $message = $this->exception->getMessage() ?: 'Minor Exception: '.get_class($this->exception);

        return response()->api()->error($message);
    }
}
