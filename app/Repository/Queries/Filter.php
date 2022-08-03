<?php

namespace App\Repository\Queries;

use Exception;
/**
 * This class is filter collection
 */
class Filter
{
    /**
     * Filter type string
     */
    const FILTER_TYPE_STRING = "string";
    /**
     * Filter type date
     */
    const FILTER_TYPE_DATE = "date";
    /**
     * Filter type integer
     */
    const FILTER_TYPE_NUMERIC = "numeric";
    /**
     * Filter operator most
     */
    const OPERATOR_TYPE_MORE = ">";
    /**
     * Filter operator less
     */
    const OPERATOR_TYPE_LESS = "<";
    /**
     * Filter operator more or equal
     */
    const OPERATOR_TYPE_MORE_OR_EQUAL = ">=";
    /**
     * Filter operator less or equal
     */
    const OPERATOR_TYPE_LESS_OR_EQUAL = "<=";
    /**
     * Filter operator type equal
     */
    const OPERATOR_TYPE_EQUAL = "=";
    /**
     * Filter operator not equal
     */
    const OPERATOR_TYPE_NOT_EQUAL = "!=";
    /**
     * Allow types
     */
    const ALLOW_TYPES = [
        self::FILTER_TYPE_DATE,
        self::FILTER_TYPE_STRING,
        self::FILTER_TYPE_NUMERIC
    ];
    /**
     * Allow operators
     */
    const ALLOW_OPERATORS = [
        self::OPERATOR_TYPE_MORE,
        self::OPERATOR_TYPE_LESS,
        self::OPERATOR_TYPE_MORE_OR_EQUAL,
        self::OPERATOR_TYPE_LESS_OR_EQUAL,
        self::OPERATOR_TYPE_EQUAL,
        self::OPERATOR_TYPE_NOT_EQUAL
    ];
    /**
     * Filter
     *
     * @var array
     */
    protected array $filter = [];
    /**
     * Equal value
     *
     * @param string $name
     * @param string $value
     * @param string $type
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function equal(string $name, string $value, string $type = self::FILTER_TYPE_STRING)
    {
        if (!in_array($type, self::ALLOW_TYPES))
            throw new Exception("{$type} is not allowed");

        $this->filter[$type][self::OPERATOR_TYPE_EQUAL] = [$name => $value];

        return $this;
    }
    /**
     * Not equal value
     *
     * @param string $name
     * @param string $value
     * @param string $type
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function notEqual(string $name, string $value, string $type = self::FILTER_TYPE_STRING)
    {
        if (!in_array($type, self::ALLOW_TYPES))
            throw new Exception("{$type} is not allowed");

        $this->filter[$type][self::OPERATOR_TYPE_NOT_EQUAL] = [$name => $value];

        return $this;
    }
    /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function less(string $name, string $value, string $reference, string $type = self::FILTER_TYPE_NUMERIC)
    {
        $ref = array_udiff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];

        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        $this->filter[$type][self::OPERATOR_TYPE_LESS] = [$name => ["value" => $value, "reference" => $reference]];

        return $this;
    }
     /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function more(string $name, string $value, string $reference, string $type = self::FILTER_TYPE_NUMERIC)
    {
        $ref = array_udiff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];

        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        $this->filter[$type][self::OPERATOR_TYPE_MORE] = [$name => ["value" => $value, "reference" => $reference]];

        return $this;
    }
     /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function lessOrEqual(string $name, string $value, string $reference, string $type = self::FILTER_TYPE_NUMERIC)
    {
        $ref = array_udiff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];

        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        $this->filter[$type][self::OPERATOR_TYPE_LESS_OR_EQUAL] = [$name => ["value" => $value, "reference" => $reference]];

        return $this;
    }
     /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function moreOrEqual(string $name, string $value, string $reference, string $type = self::FILTER_TYPE_NUMERIC)
    {
        $ref = array_udiff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];

        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        $this->filter[$type][self::OPERATOR_TYPE_MORE_OR_EQUAL] = [$name => ["value" => $value, "reference" => $reference]];

        return $this;
    }
    /**
     * Get filter
     *
     * @return array
     */
    public function get(): array
    {
        return $this->filter;
    }
}
