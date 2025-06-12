<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rootUrl = config('app.url');
        $icon =  $rootUrl . '/' . $this->icon;
        return [
            "name" => $this->name,
            "icon" => $icon,
        ];
    }
}
