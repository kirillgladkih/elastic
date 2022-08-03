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
}
