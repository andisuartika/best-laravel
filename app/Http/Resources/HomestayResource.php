<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomestayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rootUrl = config('app.url');
        $img =  $rootUrl . '/' . $this->thumbnail;
        return [
            'code' => $this->code,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'manager' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'rating' => $this->ratings_count > 0 ? round($this->ratings->avg('rating'), 1) : 0,
            'facilities' => FacilitiesResource::collection($this->whenLoaded('facilities')),
            'thumbnail' => $img,
            'reviews' => $this->ratings,
            'roomTypes' => RoomTypeResouce::collection($this->whenLoaded('roomTypes')),
            'status' => $this->status,
        ];
    }
}
