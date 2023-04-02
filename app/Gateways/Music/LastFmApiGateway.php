<?php


namespace App\Gateways\Music;



use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;


class LastFmApiGateway implements MusicContract
{
    private Client $client;
    private string $api_endpoint;
    private array $query;
    public static string $albumSearchMethod = "album.search";
    public static string $artistSearchMethod = "artist.search";

    public function __construct()
    {
        $this->client = new Client();

        $this->query = [
            'format' => 'json',
            'api_key' => env('LAST_FM_API_KEY'),
            'page' => $this->page(),
            'limit'=> 5
        ];

        $this->api_endpoint = env('LAST_FM_API_PATH');
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function fetchData(): LengthAwarePaginator
    {
        try {
            // fetch data
            $response = $this->client->get($this->api_endpoint, ['query' => $this->query]);
            // check status code
            $data = json_decode((string) $response->getBody(), true);

            if (Response::HTTP_OK !== $response->getStatusCode()){
                throw new Exception('Error retrieving data');
            }

            return $this->paginate($data);

        }catch (Exception $exception) {
            throw new Exception('Something when wrong getting data from Last.fm', $exception->getCode(), $exception);
        }
    }

    /**
     * Function triggers album and artist search query
     * @param string $method
     * @param array $query
     * @return LengthAwarePaginator
     * @throws GuzzleException
     */
    public function search(string $method, array $query): LengthAwarePaginator
    {
        $this->query = array_merge($this->query, [
            "method" => $method,
            ...$query,
        ]);

        return $this->fetchData();
    }

    /**
     * Function determines current query page
     * @param int $currentPage
     * @return int
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function page(int $currentPage = 1): int
    {
        if (request()->has('page') && is_numeric(request()->get('page'))) {
            $currentPage = (int)request()->get('page');

            // restricting page size from exceeding 10000 to prevent `page param out of bounds (1-10000)` from last.fm API
            if ($currentPage > 10000) $currentPage = 10000;
        }

        return $currentPage;
    }

    /**
     * Function paginates last.fm query results
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function paginate(array $data): LengthAwarePaginator
    {
        if ($this->query['method'] === LastFmApiGateway::$albumSearchMethod){
            $albumMatches = $data['results']['albummatches'];
            $items = $albumMatches['album'];
        }else{
            $albumMatches = $data['results']['artistmatches'];
            $items = $albumMatches['artist'];
        }

        // Extract pagination params
        $perPage = $data['results']['opensearch:itemsPerPage'];
        $query = $data['results']['opensearch:Query'];
        $resultsCount = $data['results']['opensearch:totalResults'];
        $page = $query['startPage'];

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items, $resultsCount, $perPage, $page,[
            'path' => request()->url(),
            'query' => request()->query()
        ]);
    }
}
