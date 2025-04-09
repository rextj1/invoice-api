<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'original_name' => $this->original_name,
            'url' => asset('storage/' . $this->stored_path), // ✅ Correct path
            'created_at' => $this->created_at,
        ];
    }
}
