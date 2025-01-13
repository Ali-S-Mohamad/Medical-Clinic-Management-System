<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name'  => $this->user->name,
            'email' =>$this->user->email,
            'phone' =>$this->user->phone_number,
            'specification' => $this->department->name,
            'academic qualifications' => $this->academic_qualifications,
            'previous experience' => $this->previous_experience,
            'avg ratings' => $this->avg_ratings . '/10',
        ];
    }
}
