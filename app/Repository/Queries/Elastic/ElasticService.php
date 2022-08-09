<?php

namespace App\Repository\Queries\Elastic;

use App\Repository\Queries\Filter;
use App\Repository\Queries\Interfaces\FilterType;
use App\Repository\Queries\Interfaces\LogicOperator;
use App\Repository\Queries\Interfaces\SearchType;
use App\Repository\Queries\QueryService;
use App\Repository\Queries\Searchable;
use Exception;

/**
 * This implementation query service
 */
class ElasticService extends QueryService implements SearchType, FilterType, LogicOperator
{
    /**
     * Elastic client
     *
     * @var \Elastic\Elasticsearch\Client
     */
    protected \Elastic\Elasticsearch\Client $client;
    /**
     * Elastic index
     *
     * @var string
     */
    protected string $index;
    /**
     * Elastic type
     *
     * @var string
     */
    protected string $type;
    /**
     * Elastic max document count in reposponse
     *
     * @var integer
     */
    protected int $size;
    /**
     * This query
     *
     * @var array
     */
    protected array $query = [];
    /**
     * Init
     *
     * @param \Elastic\Elasticsearch\Client $client
     * @param Searchable $searchable
     * @param Filter $filter
     */
    public function __construct(\Elastic\Elasticsearch\Client $client)
    {
        $this->client = $client;

        parent::__construct();
    }
    /**
     * Set index
     *
     * @param string $index
     * @return \App\Repository\Queries\Elastic\ElasticService
     */
    public function index(string $index)
    {
        $this->index = $index;

        return $this;
    }
    /**
     * Set size
     *
     * @param string $index
     * @return \App\Repository\Queries\Elastic\ElasticService
     */
    public function size(int $size)
    {
        $this->size = $size;

        return $this;
    }
    /**
     * Set type
     *
     * @param string $type
     * @return \App\Repository\Queries\Elastic\ElasticService
     */
    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }
    /**
     * Exceute
     *
     * @throws Exception
     * @return array
     */
    public function execute(): array
    {
        if (is_null($this->index) || is_null($this->type))
            throw new Exception("index or type was not defined use the 'index' and 'type' methods");
        /* Получение массива поиска */
        $searchable = $this->searchable->get();
        /* Получение массива фильтров */
        $filter = $this->filter->get();
        /* Парсинг для того, чтобы скормить еластику */
        $body = $this->parse($searchable, $filter);
        /* Получение ответа от еластика */
        $response = $this->client->search([
            "index" => $this->index,
            "type" => $this->type,
            "size" => $this->size,
            "body" => $body ?? []
        ]);
        /* Парсинг id , чтобы передать их в репозиторий */
        foreach ($response["hits"]["hits"] as $item)
            $ids[] = $item["_source"]["id"];

        return $ids ?? [];
    }
    /**
     * Parse filter and searchable for elastic api
     *
     * @param array $searchable
     * @param array $filter
     * @return array
     */
    private function parse(array $searchable, array $filter)
    {
        /* Соотвествие */
        foreach ($searchable as $logicType => $searchTypes) {
            foreach ($searchTypes as $searchType => $items) {
                /* Полнотесвтовый поиск или точное соответсвие */
                if (in_array($searchType, [self::SEARCH_TYPE_MATCH, self::SEARCH_TYPE_TERM]))
                    foreach ($items as $key => $item)
                        $body["query"]["bool"][$logicType][] = [$searchType => [$key => $item]];
                /* Полнотестовый поиск по полям */
                if ($searchType == self::SEARCH_TYPE_MULTI_MATCH)
                    foreach ($items as $item)
                        $body["query"]["bool"][$logicType][] = [
                            $searchType => [
                                "fields" => $item["searchables"],
                                "query" => $item["value"]
                            ]
                        ];
                /* Точное соответсвие токенизатор по условию */
                if ($searchType == self::SEARCH_TYPE_LOGIC_TERM)
                    foreach ($items as $item)
                        $body["query"]["bool"][$logicType][] = [
                            "match" => [
                                $item["searchable"] => [
                                    "query" => $item["value"],
                                    "operator" => $item["operator"]
                                ]
                            ]
                        ];
                /* Точное соответсвие по масиву */
                if ($searchType == self::SEARCH_TYPE_MULTI_TERM)
                    foreach ($items as $item)
                        $body["query"]["bool"][$logicType][] = ["terms" => [$item["searchable"] => $item["values"]]];
            }
        }
        /* Фильтры */
        foreach ($filter as $logicType => $searchTypes)
            foreach ($searchTypes as $searchType => $items)
                foreach ($items as $operator => $item)
                    foreach ($item as $key => $value)
                        $body["query"]["bool"][$logicType][] = ["range" => [$key => [$operator => $value]]];
        return $body ?? [];
    }
}
