<?php


namespace App\Repository;


use App\Gateways\Music\LastFmApiGateway;
use App\Gateways\Music\MusicContract;
use Illuminate\Pagination\LengthAwarePaginator;

class MusicRepository
{
    private MusicContract $musicContract;

    public function __construct(MusicContract $musicContract)
    {
        $this->musicContract = $musicContract;
    }

    /**
     * Query data source for albums matching query
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function get_all_albums(array $query): LengthAwarePaginator
    {
        return $this->musicContract->search(LastFmApiGateway::$albumSearchMethod, [ 'album' =>  $query['query']]);
    }

    /**
     * Query data source for albums matching query
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function get_all_artists(array $query): LengthAwarePaginator
    {
        return $this->musicContract->search(LastFmApiGateway::$artistSearchMethod, ['artist' => $query['query']]);
    }


}
