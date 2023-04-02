<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Http\Resources\MusicAlbumResource;
use App\Http\Resources\MusicArtistResource;
use App\Models\Album;
use App\Repository\MusicRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AlbumController extends Controller
{
    private MusicRepository $musicRepository;

    public function __construct(MusicRepository $musicRepository)
    {
        $this->musicRepository = $musicRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $queryParam = $request->validate(['query' => 'regex:/^[a-zA-Z0-9\s]+$/|min:3|max:255']);

        $props = [
//            'artists' => ArtistResource::collection($this->artistRepository->get_auth_user_favourite_artists()),
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        //
    }
}
