<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\MusicAlbumResource;
use App\Http\Resources\MusicArtistResource;
use App\Models\Album;
use App\Repository\AlbumRepository;
use App\Repository\MusicRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AlbumController extends Controller
{
    private MusicRepository $musicRepository;
    private AlbumRepository $albumRepository;

    public function __construct(MusicRepository $musicRepository, AlbumRepository $albumRepository)
    {
        $this->musicRepository = $musicRepository;
        $this->albumRepository = $albumRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $queryParam = $request->validate(['query' => 'regex:/^[a-zA-Z0-9\s]+$/|min:3|max:255']);

        $props = [
            'albums' => AlbumResource::collection($this->albumRepository->get_auth_user_favourite_albums()),
        ];

        if($queryParam) {
            $props = [
                ...$props,
                'search_results' => MusicAlbumResource::collection($this->musicRepository->get_all_albums($queryParam)),
                'filters' => request()->only(['page', 'query']) ?? []
            ];
        }

        return Inertia::render('Album', $props);
    }

    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $this->albumRepository->store(
            $request->validated()
        );

        return to_route('albums.index');
    }

    public function destroy(Album $album)
    {
        // delete artist
        $this->albumRepository->destroy($album);

        // redirect to home
        return to_route('albums.index');
    }
}
