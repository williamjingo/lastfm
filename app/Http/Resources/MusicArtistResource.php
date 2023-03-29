<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MusicArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $medium_image = $this['image'][1];

        return [
            'name' => $this['name'],
            'listners' => $this['listeners'],
            'image' => $medium_image['#text'],
            'mbid' => $this['mbid'],
            'streamable' => $this['streamable'],
            'url' => $this['url'],
        ];
    }
}
