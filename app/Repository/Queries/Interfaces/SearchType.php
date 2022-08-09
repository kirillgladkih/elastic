<?php

namespace App\Repository\Queries\Interfaces;

interface SearchType
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
     * Search logic term
     */
    const SEARCH_TYPE_LOGIC_TERM = "logic_term";
}
