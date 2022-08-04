<?php

namespace App\Repository\Mapping\Elastic\Interfaces;

interface ElasticMap
{
    /**
     * Text for an inexact match type
     */
    const MAP_TYPE_TEXT = "text";
    /**
     * Integer type
     */
    const MAP_TYPE_INTEGER = "integer";
    /**
     * Date type
     */
    const MAP_TYPE_DATE = "date";
    /**
     * Text for for an exact match or array type
     */
    const MAP_TYPE_KEYWORD = "keyword";
    /**
     * Boolean type
     */
    const MAP_TYPE_BOOLEAN = "boolean";
    /**
     * Type for autocomplete
     */
    const MAP_TYPE_COMPLETION = "completion";
    /**
     * Get index
     *
     * @return string
     */
    public function index(): string;
    /**
     * Get type
     *
     * @return string
     */
    public function type(): string;
    /**
     * Get source for document
     *
     * @return array
     */
    public function source(): array;
}
