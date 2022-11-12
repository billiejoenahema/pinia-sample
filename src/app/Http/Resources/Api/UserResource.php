<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'zipcode' => $this->zipcode,
            'pref' => $this->pref,
            'city' => $this->city,
            'street' => $this->street,
            'total_working_time' => $this->total_working_time,
            'attendances' => AttendanceResource::collection($this->attendances),
        ];
    }
}
