<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
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
            'destinations' => DestinationResource::collection($this->whenLoaded('destinations')),
            'included' => json_decode($this->included),
            'price' => $this->price,
            'manager' => $this->user->name,
            'thumbnail' => $img,
            'status' =>  $this->status,
        ];
    }
}
