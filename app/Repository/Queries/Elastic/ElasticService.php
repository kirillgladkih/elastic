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

        $searchable = $this->searchable->get();

        $filter = $this->filter->get();

        $body = $this->parse($searchable, $filter);

        $response = $this->client->search([
            "index" => $this->index,
            "type" => $this->type,
            "size" => $this->size,
            "body" => $body
        ]);

        foreach ($response["hits"]["hits"] as $item)
            $ids[] = $item["_source"]["id"];

        return $ids ?? [];
    }
    /**
     * Parse filter and searchable for elastic api
     *
     * @param array $searchable
     * @param array $filter
     * @return void
     */
    private function parse(array $searchable, array $filter)
    {
        foreach ($searchable as $logicType => $searchTypes) {

            foreach ($searchTypes as $searchType => $items) {

                if (in_array($searchType, [self::SEARCH_TYPE_MATCH, self::SEARCH_TYPE_TERM])) {

                    foreach ($items as $key => $item) {

                        $body["query"]["bool"][$logicType][] = [$searchType => [$key => $item]];
                    }
                }

                if($searchType == self::SEARCH_TYPE_MULTI_MATCH){

                    $body["query"]["bool"][$logicType][$searchType] = [
                        "fields" => $items["searchables"],
                        "query" => $items["value"]
                    ];

                }
            }
        }

        return $body;
    }
}
