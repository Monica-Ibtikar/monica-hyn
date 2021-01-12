<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    protected $code;
    protected $message;
    protected $errors;

    public function __construct($code, $message = "Failed operation", $error = "")
    {
        $this->code = $code;
        $this->message = $message;
        if($error != "" && is_array($error) == false) { //if $error is passed to the resource as string (but not empty string) target is the default key name of errors
            $this->errors = ["target" => $error];
        }else{
            //here $error is passed as an array or not passed
            $this->errors = $error;
        }
    }

    public function toArray($request)
    {
        return [
            "message" => $this->message,
            "errors" => $this->errors,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->code);
    }
}
