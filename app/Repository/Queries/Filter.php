<?php

namespace App\Repository\Queries;

use App\Repository\Queries\Interfaces\FilterType;
use App\Repository\Queries\Interfaces\LogicOperator;
use App\Repository\Queries\Interfaces\OperatorType;
use Exception;

/**
 * This class is filter collection
 */
class Filter implements FilterType, OperatorType, LogicOperator
{
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
     * Allow logic operator
     */
    const ALLOW_LOGIC_OPERATORS = [
        self::LOGIC_OPERATOR_AND,
        self::LOGIC_OPERATOR_NOT,
        self::LOGIC_OPERATOR_OR
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
     * @param string $logicOperator
     * @return void
     */
    public function equal(
        string $name,
        string $value,
        string $type = self::FILTER_TYPE_STRING,
        string $logicOperator = self::LOGIC_OPERATOR_AND
    ) {
        if (!in_array($type, self::ALLOW_TYPES))
            throw new Exception("{$type} is not allowed");

        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        $this->filter[$logicOperator][$type][self::OPERATOR_TYPE_EQUAL] = [$name => $value];

        return $this;
    }
    /**
     * Not equal value
     *
     * @param string $name
     * @param string $value
     * @param string $type
     * @param string $logicOperator
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function notEqual(
        string $name,
        string $value,
        string $type = self::FILTER_TYPE_STRING,
        string $logicOperator = self::LOGIC_OPERATOR_AND
    ) {
        if (!in_array($type, self::ALLOW_TYPES))
            throw new Exception("{$type} is not allowed");

        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        $this->filter[$logicOperator][$type][self::OPERATOR_TYPE_NOT_EQUAL] = [$name => $value];

        return $this;
    }
    /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @param string $logicOperator
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function less(
        string $name,
        string $value,
        string $reference,
        string $type = self::FILTER_TYPE_NUMERIC,
        string $logicOperator = self::LOGIC_OPERATOR_AND
    ) {
        $ref = array_diff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];
        dd($type);
        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        $this->filter[$logicOperator][$type][self::OPERATOR_TYPE_LESS] = [$name => ["value" => $value, "reference" => $reference]];

        return $this;
    }
    /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @param string $logicOperator
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function more(
        string $name,
        string $value,
        string $reference,
        string $type = self::FILTER_TYPE_NUMERIC,
        string $logicOperator = self::LOGIC_OPERATOR_AND
    ) {
        $ref = array_diff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];

        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        $this->filter[$logicOperator][$type][self::OPERATOR_TYPE_MORE] = [$name => ["value" => $value, "reference" => $reference]];

        return $this;
    }
    /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @param string $logicOperator
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function lessOrEqual(
        string $name,
        string $value,
        string $reference,
        string $type = self::FILTER_TYPE_NUMERIC,
        string $logicOperator = self::LOGIC_OPERATOR_AND
    ) {
        $ref = array_diff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];

        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        $this->filter[$logicOperator][$type][self::OPERATOR_TYPE_LESS_OR_EQUAL] = [$name => ["value" => $value, "reference" => $reference]];

        return $this;
    }
    /**
     * Less
     *
     * @param string $name
     * @param string $value
     * @param string $reference
     * @param string $type
     * @param string $logicOperator
     * @throws Exception
     * @return \App\Repository\Queris\Filter
     */
    public function moreOrEqual(
        string $name,
        string $value,
        string $reference,
        string $type = self::FILTER_TYPE_NUMERIC,
        string $logicOperator = self::LOGIC_OPERATOR_AND
    ) {
        $ref = array_diff([self::FILTER_TYPE_STRING], self::ALLOW_TYPES) ?? [];

        if (!in_array($type, $ref))
            throw new Exception("{$type} is not allowed");

        if (!in_array($logicOperator, self::ALLOW_LOGIC_OPERATORS))
            throw new Exception("not allowed logic operator");

        $this->filter[$logicOperator][$type][self::OPERATOR_TYPE_MORE_OR_EQUAL] = [$name => ["value" => $value, "reference" => $reference]];

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
