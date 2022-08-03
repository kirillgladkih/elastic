<?php

namespace App\Repository\Queries;
/**
 * This class is searchable collection
 */
class Searchable
{
    /**
     * Search type match
     */
    const SEARCH_TYPE_MATCH = "match";
    /**
     * Search type multi match
     */
    const SEARCH_TYPE_MULTI_MATCH = "multi_match";
    /**
     * Search type term
     */
    const SEARCH_TYPE_TERM = "term";
    /**
     * Search type multi term
     */
    const SEARCH_TYPE_MULTI_TERM = "multi_term";
    /**
     * Search array
     *
     * @var array
     */
    protected array $search = [];
    /**
     * Full text match
     *
     * @param string $searchable
     * @param string $value
     * @return \App\Repository\Queris\Searchable
     */
    public function fullTextMatch(string $searchable, string $value)
    {
        $this->search[self::SEARCH_TYPE_MATCH][$searchable] = $value;

        return $this;
    }
    /**
     * Full text multi match
     *
     * @param array $searchables
     * @param string $value
     * @return \App\Repository\Queris\Searchable
     */
    public function fullTextMultiMatch(array $searchables, string $value)
    {
        foreach ($searchables as $searchable)
            $this->search[self::SEARCH_TYPE_MULTI_MATCH][$searchable] = $value;

        return $this;
    }
    /**
     * Term match
     *
     * @param string $searchable
     * @param string $value
     * @return \App\Repository\Queris\Searchable
     */
    public function termMatch(string $searchable, string $value)
    {
        $this->search[self::SEARCH_TYPE_TERM][$searchable] = $value;

        return $this;
    }
    /**
     * Term multi match
     *
     * @param array $searchables
     * @param string $value
     * @return \App\Repository\Queris\Searchable
     */
    public function termMultiMatch(array $searchables, string $value)
    {
        foreach ($searchables as $searchable)
            $this->search[self::SEARCH_TYPE_MULTI_TERM][$searchable] = $value;

        return $this;
    }
    /**
     * Get search array
     *
     * @return array
     */
    public function get()
    {
        return $this->search;
    }
}
