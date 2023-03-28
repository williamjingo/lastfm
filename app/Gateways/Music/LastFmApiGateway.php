<?php


namespace App\Gateways\Music;



use GuzzleHttp\Client;

class LastFmApiGateway implements MusicContract
{
    private Client $client;
    private string $api_key;
    private string $api_secret;
    private string $api_endpoint;
    private array $query;

    public function __construct()
    {
        $this->client = new Client();
        $this->query = [
            'format' => 'json',
            'api_key' => env('LAST_FM_API_KEY')
        ];

        $this->api_endpoint = env('LAST_FM_API_PATH');
    }

    public function fetchData()
    {
        try {
            // fetch data
            $response = $this->client->get($this->api_endpoint, ['query' => $this->query]);

            return json_decode((string) $response->getBody(), true);

        }catch (\Exception $exception) {
            dd('Something when wrong getting data from Last.fm', $exception->getCode(), $exception);
        }
    }

    public function search(string $method, array $query)
    {
        $this->query = array_merge($this->query, [
            "method" => $method,
            ...$query,
        ]);

        $data = $this->fetchData();

        dd($data);

        return collect($data);
    }
}
