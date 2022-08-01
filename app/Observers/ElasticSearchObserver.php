<?php

namespace App\Observers;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;

class ElasticSearchObserver extends AObserver
{
    /**
     * Client
     *
     * @param Client $client
     */
    private $client;
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
     * Saving hook
     *
     * @param Model $model
     * @return void
     */
    public function saved(Model $model)
    {
        $this->client->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }
    /**
     * Deleting hook
     *
     * @param Model $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->client->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
