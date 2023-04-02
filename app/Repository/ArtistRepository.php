<?php


namespace App\Repository;


use App\Models\Artist;

class ArtistRepository
{
    public function get_auth_user_favourite_artists()
    {
        return Artist::latest()->paginate(5, ['*'], 'artists')->withQueryString();
    }

    public function store(array $data)
    {
        return Artist::create($data);
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
    }
}
