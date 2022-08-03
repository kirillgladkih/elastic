<?php

namespace App\Repository\Queries\Interfaces;

interface OperatorType
{

    /**
     * Filter operator more
     */
    const OPERATOR_TYPE_MORE = "gt";
    /**
     * Filter operator less
     */
    const OPERATOR_TYPE_LESS = "lt";
    /**
     * Filter operator more or equal
     */
    const OPERATOR_TYPE_MORE_OR_EQUAL = "gte";
    /**
     * Filter operator less or equal
     */
    const OPERATOR_TYPE_LESS_OR_EQUAL = "lte";
}
