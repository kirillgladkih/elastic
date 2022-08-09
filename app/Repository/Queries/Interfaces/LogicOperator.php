<?php

namespace App\Repository\Queries\Interfaces;

interface LogicOperator
{
    /**
     * Or operator
     */
    const LOGIC_OPERATOR_OR = "should";
    /**
     * And operator
     */
    const LOGIC_OPERATOR_AND = "must";
    /**
     * Not operator
     */
    const LOGIC_OPERATOR_NOT = "must_not";
     /**
     * Logic for term match and
     */
    const LOGIC_OPERATOR_FOR_TERM_AND = "and";
    /**
     * Logic for term match or
     */
    const LOGIC_OPERATOR_FOR_TERM_OR = "or";
}
