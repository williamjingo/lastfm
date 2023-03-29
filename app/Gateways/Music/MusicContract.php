<?php


namespace App\Gateways\Music;



interface MusicContract
{
    public function search(string $method, array $query);
}
