<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpensesResource extends JsonResource
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
            'id'=>$this->vehicle_id,
            'vehicleName'=> $this->name,
            'plateNumber'=>$this->plate_number,
            'type'=> $this->type,
            'cost'=>$this->cost,
            'createdAt'=>$this->createdAt
        ];


        //return parent::toArray($request);
    }
}
