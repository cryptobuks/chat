<?php

namespace App\Chatter\Exceptions;

use Exception;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Support\Responsable;

class ApiValidationException extends Exception implements Responsable
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @param Validator $validator
     */
    public function __construct($exception)
    {
        $this->validator = $exception->validator;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return response()->api()->validation($this->validator->errors()->first());
    }
}
