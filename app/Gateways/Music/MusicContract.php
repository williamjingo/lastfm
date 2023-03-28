<?php


namespace App\Gateways\Music;


use Illuminate\Http\Client\Request;

interface MusicContract
{
    public function search(string $method, array $query);
}
