<?php


namespace App\Repository;


use App\Models\Album;

class AlbumRepository
{
    public function get_auth_user_favourite_albums()
    {
        return Album::latest()->paginate(5, ['*'], 'albums')->withQueryString();
    }

    public function store(array $data)
    {
        return Album::create($data);
    }

    public function destroy(Album $album)
    {
        $album->delete();
    }
}
