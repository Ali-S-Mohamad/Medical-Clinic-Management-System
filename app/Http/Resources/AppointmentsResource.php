<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentsResource extends JsonResource
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
            'doctor'  => $this->employee->user->firstname .' '. $this->employee->user->lastname ,
            'date' => $this->appointment_date,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }


    /**
     * Summary of collection
     * @param mixed $resource
     * @return array
     */
    public static function collection($resource)
    {
        $paginator = $resource instanceof LengthAwarePaginator;

        return [
            'data' => parent::collection($resource),
            'pagination' => $paginator ? [
                'current_page' => $resource->currentPage(),
                'total_pages' => $resource->lastPage(),
                'previous' => $resource->previousPageUrl(),
                'next' => $resource->nextPageUrl(),
            ] : null,
        ];
    }
}
