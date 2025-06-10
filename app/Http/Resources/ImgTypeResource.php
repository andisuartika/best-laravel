<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImgTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rootUrl = config('app.url');
        $img =  $rootUrl . '/' . $this->url;
        return [
            'title' => $this->title,
            'description' => $this->description,
            'url' => $img,
        ];
    }
}
