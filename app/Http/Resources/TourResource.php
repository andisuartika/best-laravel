<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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

        $today = Carbon::today();

        // Ambil hanya rate yang valid hari ini
        $activeRates = $this->rates->filter(function ($rate) use ($today) {
            return $today->between(Carbon::parse($rate->valid_from), Carbon::parse($rate->valid_to));
        });
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'village_id' => $this->village_id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'destinations' => DestinationResource::collection($this->whenLoaded('destinations')),
            'included' => json_decode($this->included),
            'price' => optional($activeRates->sortBy('price')->first())->price,
            'active_prices' => $activeRates->values()->map(function ($rate) {
                return [
                    "id" => $rate->id,
                    'name' => $rate->name,
                    'price' => (int) $rate->price,
                    'valid_from' => $rate->valid_from,
                    'valid_to' => $rate->valid_to,
                ];
            }),
            'manager' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            'rating' => $this->ratings_count > 0 ? round($this->ratings->avg('rating'), 1) : 0,
            'reviews' => $this->ratings,
            'thumbnail' => $img,
            'status' =>  $this->status,
        ];
    }
}
