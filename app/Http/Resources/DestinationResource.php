<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rootUrl = config('app.url');
        $img =  $rootUrl . '/' . $this->thumbnail;
        return [
            'id' => $this->id,
            'village_id' => $this->village_id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'category' => $this->category,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'manager' => $this->user->name,
            'image' => $img,
            'status' =>  $this->status,
        ];
    }
}
