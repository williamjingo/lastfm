<?php


namespace App\Repository;


use App\Models\Artist;

class ArtistRepository
{
    public function get_auth_user_favourite_artists()
    {
        return Artist::paginate(10, ['*'], 'artists');
    }

    public function store(array $data)
    {
        return Artist::create($data);
    }
}
