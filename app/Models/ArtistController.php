<?php

namespace App\Models;

use App\Http\Resources\MusicAlbumResource;
use App\Http\Resources\MusicArtistResource;
use App\Repository\MusicRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArtistController extends Model
{
    use HasFactory;

    private MusicRepository $musicRepository;

    public function __construct(MusicRepository $musicRepository)
    {
        $this->musicRepository = $musicRepository;
    }

    public function index(Request $request): Response
    {
        $queryParam = $request->validate(['query' => 'regex:/^[a-zA-Z0-9\s]+$/|min:3|max:255']);

        if(!$queryParam) return Inertia::render('Artist');

        return  Inertia::render('Artist',
            [
                'search_results' => MusicArtistResource::collection($this->musicRepository->get_all_artists($queryParam)),
                'filters' => request()->only(['page', 'query']),
            ]);
    }
}
