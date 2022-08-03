<?php

namespace App\Repository;

use App\Repository\Queries\Elastic\ElasticService;
use App\Repository\Queries\Filter;
use App\Repository\Queries\QueryService;
use App\Repository\Queries\Searchable;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Abstract repository class
 */
abstract class ARepository
{
    /**
     * Get model instance
     *
     * @return Model
     */
    abstract protected function start(): Model;
    /**
     * This query builder
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected \Illuminate\Database\Eloquent\Builder $builder;
    /**
     * This query service
     *
     * @var \App\Repository\Queries\QueryService
     */
    protected \App\Repository\Queries\QueryService $queryService;
    /**
     * Init
     */
    public function __construct()
    {
        $this->builder = $this->start()->where("id", ">", "0");
        $this->queryService = $this->getQueryService();
    }
    /**
     * Get query service
     *
     * @return QueryService
     */
    protected function getQueryService(): QueryService
    {
        /* here the strategy for connecting the service should be implemented */
        $hosts = config("app.search.hosts");

        $client = ClientBuilder::create()->setHosts($hosts)->build();

        $service = new ElasticService($client);

        $service->index($this->start()->getSearchType())
            ->type($this->start()->getSearchIndex())
            ->size($this->start()->select("id")->count());

        return $service;
    }
    /**
     * Get filter
     *
     * @return \App\Repository\Queries\Filter
     */
    public function filter()
    {
        return $this->queryService->filter();
    }
    /**
     * Get searchable
     *
     * @return \App\Repository\Queries\Searchable
     */
    public function searchable()
    {
        return $this->queryService->searchable();
    }
    /**
     * Get
     *
     * @return void
     */
    public function get()
    {
        $this->queryService->searchable()->termMatch("ff", "ff");

        $this->execute();

        return $this->builder->get();
    }

    protected function execute()
    {
        $ids = $this->queryService->execute();

        $this->builder = $this->builder->whereIn("id", $ids);
    }
}
