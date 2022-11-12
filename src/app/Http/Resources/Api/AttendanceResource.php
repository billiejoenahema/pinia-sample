<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'working_date' => $this->working_date,
            'in_time' => $this->in_time->format('H:i'),
            'out_time' => $this->out_time->format('H:i'),
            'rest_time' => $this->rest_time->format('H:i'),
            'working_time' => $this->working_time,
        ];
    }
}
