<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class patient extends JsonResource
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
            'user_neme' => $this->user_name,
            'role' => $this->role,
            'info' => $this->patient,
        ];
    }
}
