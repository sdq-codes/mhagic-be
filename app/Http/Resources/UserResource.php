<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'user_type' => $this->user_type,
            'active' => (bool) $this->active,
            'last_activity_entry' =>  $this->last_activity_entry,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'access_token' => $this->when($this->access_token,function (){return $this->access_token;}),
        ];
        return  $response;
    }
}
