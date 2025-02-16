<?php

namespace App\Http\Resources;

use App\Models\DestinationImage;
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
            'tickets' => TicketResource::collection($this->whenLoaded('prices')),
            'address' => $this->address,
            'category' => CategoryResource::collection($this->whenLoaded('categories')),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'manager' => $this->user->name,
            'facilities' => json_decode($this->facilities),
            'thumbnail' => $img,
            'galleries' => DestinationImgResource::collection($this->whenLoaded('images')),
            'status' =>  $this->status,
        ];
    }
}
