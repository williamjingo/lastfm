<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class MusicAlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $medium_image = $this['image'][0];

        return [
            'id' => (string) Str::uuid(), // used just because no unique ids are returned from the Last.fm api
            'name' => $this['name'],
            'artist' => $this['artist'],
            'image' => $medium_image['#text'],
            'url' => $this['url'],
            'mbid' => $this['mbid'],
        ];
    }
}
