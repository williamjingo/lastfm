<?php

namespace App\Http\Controllers;

use App\Http\Resources\MusicAlbumResource;
use App\Repository\MusicRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MusicController extends Controller
{
    private MusicRepository $musicRepository;

    public function __construct(MusicRepository $musicRepository)
    {
        $this->musicRepository = $musicRepository;
    }

    public function index(Request $request): Response
    {
        $queryParam = $request->validate(['query' => 'regex:/^[a-zA-Z0-9\s]+$/|min:3|max:255']);

        if(!$queryParam) return Inertia::render('Dashboard', [
            'albums' => [],
            'artists' => [],
        ]);

        return  Inertia::render('Dashboard',
        [
            'albums' => MusicAlbumResource::collection($this->musicRepository->get_all_albums($queryParam)),
//            'artists' => $this->musicRepository->get_all_artists($queryParam)
        ]);
    }
}
