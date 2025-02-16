<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResouce extends JsonResource
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
            'capacity' => $this->capacity,
            'facilities' => json_decode($this->facilities),
            'price' => $this->price,
            'thumbnail' => $img,
            'rooms' => RoomResource::collection($this->whenLoaded('rooms')),
            'galleries' => ImgTypeResource::collection($this->whenLoaded('imageRoom')),
        ];
    }
}
