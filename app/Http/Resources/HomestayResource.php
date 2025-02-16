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
            'name' => $this->name,
            'description' => $this->description,
            'manager' => $this->user->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'facilities' => json_decode($this->facilities),
            'thumbnail' => $img,
            'roomTypes' => RoomTypeResouce::collection($this->whenLoaded('roomTypes')),
            'status' => $this->status,
        ];
    }
}
