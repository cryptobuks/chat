<?php

namespace App\Chatter\Exceptions;;

use Exception;
use Illuminate\Contracts\Support\Responsable;

class ApiUnauthenticatedException extends Exception implements Responsable
{
    /**
     * @param Exception $validator
     */
    public function __construct($exception)
    {
        //
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return response()->api()->unauthenticated();
    }
}
