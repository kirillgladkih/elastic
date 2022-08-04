<?php

namespace App\Repository\Queries;

use App\Repository\Queries\Interfaces\LogicOperator;
use App\Repository\Queries\Interfaces\SearchType;
use Exception;

/**
 * This class is searchable collection
 */
class Searchable implements LogicOperator, SearchType
{
    /**
     * Search array
     *
     * @var array
     */
    protected array $search = [];
    /**
     * Allow logic operator
     */
    const ALLOW_LOGIC_OPERATORS = [
        self::LOGIC_OPERATOR_AND,
        self::LOGIC_OPERATOR_NOT,
        self::LOGIC_OPERATOR_OR
    ];
    /**
     * Full text match
     *
     * @param string $searchable
     * @param string $value
     * @param string $logic operator
     * @throws Exception
     * @return \App\Repository\Queris\Searchable
     */
    public function fullTextMatch(string $searchable, string $value, string $logicOperator = self::LOGIC_OPERATOR_AND)
    {
        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        if (!empty($value) && !empty($searchable))
            $this->search[$logicOperator][self::SEARCH_TYPE_MATCH][$searchable] = $value;

        return $this;
    }
    /**
     * Full text multi match
     *
     * @param array $searchables
     * @param string $value
     * @param string $logic operator
     * @throws Exception
     * @return \App\Repository\Queris\Searchable
     */
    public function fullTextMultiMatch(array $searchables, string $value, string $logicOperator = self::LOGIC_OPERATOR_AND)
    {
        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        if (!empty($value) && !empty($searchables))
            $this->search[$logicOperator][self::SEARCH_TYPE_MULTI_MATCH][] = ["value" => $value, "searchables" => $searchables];

        return $this;
    }
    /**
     * Term match
     *
     * @param string $searchable
     * @param string $value
     * @param string $logic operator
     * @throws Exception
     * @return \App\Repository\Queris\Searchable
     */
    public function termMatch(string $searchable, string $value, string $logicOperator = self::LOGIC_OPERATOR_AND)
    {
        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        if (!empty($value) && !empty($searchable))
            $this->search[$logicOperator][self::SEARCH_TYPE_TERM][$searchable] = $value;

        return $this;
    }
    /**
     * Term match
     *
     * @param string $searchable
     * @param array $values
     * @param string $logic operator
     * @throws Exception
     * @return \App\Repository\Queris\Searchable
     */
    public function termMultiMatch(string $searchable, array $values, string $logicOperator = self::LOGIC_OPERATOR_AND)
    {
        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        if (!empty($values) && !empty($searchable))
            $this->search[$logicOperator][self::SEARCH_TYPE_MULTI_TERM][] = ["values" => $values, "searchable" => $searchable];

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
