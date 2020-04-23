<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientBookings extends JsonResource
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
            'booking_info'  => [
                'booking_no'    => $this->booking_no,
                'booking_date'  => $this->created_at,
            ],
            'medical'       => [
                'id'            => $this->medical->id, 
                'reg_no'        => $this->medical->reg_no, 
                'center_name'   => $this->medical->center_name, 
                'dr_name'       => $this->medical->dr_name, 
                'specialist_in' => $this->medical->specialist_in, 
                'start_time'    => $this->medical->start_time, 
                'end_time'      => $this->medical->end_time, 
                'open_days'     => $this->medical->open_days, 
                'city'          => $this->medical->city, 
                'district'      => $this->medical->district, 
                'dr_notes'      => $this->medical->dr_notes
            ]
        ];
    }
}
