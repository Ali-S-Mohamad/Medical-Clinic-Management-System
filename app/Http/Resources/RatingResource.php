<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;  


class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient_id' => $this -> patient_id,
            'doctor_id'  => $this -> doctor_id,
            'doctor_rate'=> $this -> doctor_rate,
            'details'    => $this -> details,
        ];
    }

    // كونو عم استخدم ريسورس للريسبونس + باجينيشن فما عم يرجعو الروابط..
    //  هي الطريقة بتختبر اذا في روابط رجعن
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
