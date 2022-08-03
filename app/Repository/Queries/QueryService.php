<?php

namespace App\Repository\Queries;

/**
 * This abstract class for query services
 */
abstract class QueryService
{
    /**
     * Searchable query
     *
     * @var Searchable
     */
    protected Searchable $searchable;
    /**
     * Filter query
     *
     * @var Filter
     */
    protected Filter $filter;
    /**
     * Init
     */
    public function __construct()
    {
        $this->searchable = new Searchable();
        $this->filter = new Filter();
    }
    /**
     * Get searchable collection
     *
     * @return Searchable
     */
    public function searchable(): Searchable
    {
        return $this->searchable;
    }
    /**
     * Get filter collection
     *
     * @return Filter
     */
    public function filter(): Filter
    {
        return $this->filter;
    }
    /**
     * Execute
     * Return matching ids
     *
     * @return array
     */
    abstract public function execute(): array;
}
