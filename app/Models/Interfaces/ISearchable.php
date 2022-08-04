<?php

namespace App\Models\Interfaces;

interface ISearchable
{
    /**
     * Get search index
     *
     * @return string
     */
    public function getSearchIndex();
    /**
     * Get search type
     *
     * @return string
     */
    public function getSearchType();
    /**
     * To search array
     *
     * @return array
     */
    public function toSearchArray();
    /**
     * Get mappginh
     *
     * @return array
     */
    public function getMapp(): array;
}
