<?php

namespace App\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "customer_name" => $this->customer_name,
            "customer_phone" => $this->customer_phone,
            "total" => $this->total,
            "status" => Status::getInstance($this->status)->key,
            "products" => ProductResource::collection($this->products)
        ];
    }
}
