<?php

namespace App\Repository\Queries\Interfaces;

interface OperatorType
{
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
}
