<?php

namespace App\Repository;

use App\Models\Article;
use App\Models\Interfaces\ISearchable;
use App\Repository\Queries\Elastic\ElasticService;
use App\Repository\Queries\QueryService;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Model;

class SearchRepository
{
    /**
     * Query service instance
     *
     * @var QueryService
     */
    protected QueryService $queryService;
    /**
     * Model
     *
     * @var Model
     */
    protected ISearchable $model;
    /**
     * Init
     *
     * @param ISearchable $model
     */
    public function __construct(ISearchable $model)
    {
        $this->model = $model;
        $this->queryService = $this->getQueryService();
    }
    /**
     * Strategy for query service
     *
     * @return QueryService
     */
    protected function getQueryService(): QueryService
    {
        /* Здесь должна быть реализация подключения разных сервисов
            в зависимости от ситуации в данно случае стоит еластик*/
        $hosts = config("app.search.hosts");

        $client = ClientBuilder::create()->setHosts($hosts)->build();

        $service = new ElasticService($client);

        $service->index($this->model->getSearchType())
            ->type($this->model->getSearchIndex())
            ->size($this->model->select("id")->count());

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
     * Get builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder(): \Illuminate\Database\Eloquent\Builder
    {
        $ids = $this->queryService->execute();

        return $this->model->whereIn("id", $ids);
    }
    /**
     * Get collection result
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(): \Illuminate\Support\Collection
    {
        return $this->getBuilder()->get();
    }
}
