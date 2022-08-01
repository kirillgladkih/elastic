<?php

namespace App\Repository\Search;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Elastic implements SearchInterface
{
    /**
     * Client
     *
     * @var Client
     */
    protected $client;
    /**
     * Init
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    /**
     * Search
     *
     * @param string $query
     * @param Model $model
     * @param string $searchables
     * @return Collection
     */
    public function search(string $query = "", Model $model, string $searchable = ""): Collection
    {
        $response = $this->client->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'match' => [
                        $searchable => $query,
                    ],
                ],
            ],
        ]);

        foreach ($response["hits"]["hits"] ?? [] as $item)
            $result[] = $item["_source"];

        return collect($result ?? []);
    }
    /**
     * Multi search
     *
     * @param string $query
     * @param Model $model
     * @param array $searchables
     * @return Collection
     */
    public function multiSearch(string $query = "", Model $model, array $searchables = []): Collection
    {
        $response = $this->client->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => $searchables,
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        foreach ($response["hits"]["hits"] ?? [] as $item)
            $result[] = $item["_source"];

        return collect($result ?? []);
    }
}
