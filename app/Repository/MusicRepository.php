<?php


namespace App\Repository;


use App\Gateways\Music\MusicContract;

class MusicRepository
{
    private MusicContract $musicContract;

    public function __construct(MusicContract $musicContract)
    {
        $this->musicContract = $musicContract;
    }

    public function get_all_albums(array $query)
    {
        return $this->musicContract->search('album.search',[ 'album' =>  $query['query']]);
    }

    public function get_all_artists(array $query)
    {
        return $this->musicContract->search('artist.search', ['artist' => $query['query']]);
    }
}
