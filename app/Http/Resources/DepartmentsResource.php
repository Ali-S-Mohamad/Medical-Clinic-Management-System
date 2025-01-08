<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentsResource extends JsonResource
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
            'name'  => $this->name,
            'description' => $this->description,
        ];
    }

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
