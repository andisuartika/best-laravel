<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $today = Carbon::today();

        // Ambil hanya rate yang valid hari ini
        $activeRates = $this->rates->filter(function ($rate) use ($today) {
            return $today->between(Carbon::parse($rate->valid_from), Carbon::parse($rate->valid_to));
        });

        return [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'capacity' => $this->capacity,
            'facilities' => json_decode($this->facilities),
            'price' => optional($activeRates->sortBy('price')->first())->price,
            'active_prices' => $activeRates->values()->map(function ($rate) {
                return [
                    'name' => $rate->name,
                    'price' => (int) $rate->price,
                    'valid_from' => $rate->valid_from,
                    'valid_to' => $rate->valid_to,
                ];
            }),

            'thumbnail' => $img,
            'rooms' => RoomResource::collection($this->whenLoaded('rooms')),
            'galleries' => ImgTypeResource::collection($this->whenLoaded('imageRoom')),
        ];
    }
}
