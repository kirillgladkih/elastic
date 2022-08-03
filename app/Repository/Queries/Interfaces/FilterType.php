<?php

namespace App\Repository\Queries\Interfaces;

interface FilterType
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
}
