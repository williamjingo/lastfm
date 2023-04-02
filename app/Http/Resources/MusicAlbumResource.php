<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MusicAlbumResource extends JsonResource
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
            'id' => $this['mbid'],
            'name' => $this['name'],
            'artist' => $this['artist'],
            'image' => $medium_image['#text'],
            'url' => $this['url'],
            'streamable' => $this['streamable'],
            'mbid' => $this['mbid'],
        ];
    }
}
