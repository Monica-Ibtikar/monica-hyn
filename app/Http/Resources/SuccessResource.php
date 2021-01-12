<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SuccessResource extends JsonResource
{
    protected $code;
    protected $message;
    protected $data;

    public function __construct($code = Response::HTTP_OK, $message = "Successful operation", $data = ""){

        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function toArray($request)
    {
        return [
            "message" => $this->message,
            "data" => $this->data,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->code);
    }
}
