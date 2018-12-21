<?php

namespace App\Chatter\Response;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

class ResponseModifier implements Responsable
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var integer
     */
    protected $code = 200;

    /**
     * @var boolean
     */
    protected $status = true;

    /**
     * @var string
     */
    protected $message = 'OK';

    /**
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * @param integer $code
     * @return ResponseModifier
     */
    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param boolean $code
     * @return ResponseModifier
     */
    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $message
     * @return ResponseModifier
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param array $attributes
     * @return ResponseModifier
     */
    public function merge(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param string $message
     * @return ResponseModifier
     */
    public function unauthorized()
    {
        return $this->error('Unauthorized request', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return ResponseModifier
     */
    public function unauthenticated()
    {
        return $this->error('Unauthenticated request.', Response::HTTP_FORBIDDEN);
    }

    /**
     * @param string $message
     * @return ResponseModifier
     */
    public function validation($message)
    {
        return $this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param string $message
     * @param integer $code
     * @return ResponseModifier
     */
    public function error($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->status(false)->message($message)->code($code);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return response()->json([
            'status' => $this->status,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data
        ] + $this->attributes);
    }
}
