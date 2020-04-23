<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalBooking extends JsonResource
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
            'booking_info' => [
                'booking_no'    => $this->booking_no,
                'booking_date'  => $this->created_at
            ],
            'patient'    => [
                'id'            => $this->patient->id,
                'first_name'    => $this->patient->first_name,
                'last_name'     => $this->patient->last_name,
                'nic'           => $this->patient->nic,
                'mobile_number' => $this->patient->mobile_number,
                'email'         => $this->patient->email,
                'city'          => $this->patient->city,
                'district'      => $this->patient->district,
                'medi_track'    => $this->patient->medi_track
            ]
        ];
    }
}
