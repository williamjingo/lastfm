<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\MusicArtistResource;

use App\Models\Artist;
use App\Repository\ArtistRepository;
use App\Repository\MusicRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArtistController extends Controller
{

    private MusicRepository $musicRepository;
    private ArtistRepository $artistRepository;


    public function __construct(MusicRepository $musicRepository, ArtistRepository $artistRepository)
    {
        $this->musicRepository = $musicRepository;
        $this->artistRepository = $artistRepository;
    }

    public function index(Request $request): Response
    {
        $queryParam = $request->validate(['query' => 'regex:/^[a-zA-Z0-9\s]+$/|min:3|max:255']);

        $props = [
            'artists' => ArtistResource::collection($this->artistRepository->get_auth_user_favourite_artists()),
        ];

        if($queryParam) {
            $props = [
                ...$props,
                'search_results' => MusicArtistResource::collection($this->musicRepository->get_all_artists($queryParam)),
                'filters' => request()->only(['page', 'query']) ?? []
            ];
        }

        return  Inertia::render('Artist', $props);
    }

    public function store(PostArtistRequest $request): RedirectResponse
    {
        $this->artistRepository->store(
            $request->validated()
        );

        return to_route('artists.index');
    }

    public function destroy(Artist $artist)
    {
        // delete artist
        $this->artistRepository->destroy($artist);

        // redirect to home
        return to_route('artists.index');
    }
}
