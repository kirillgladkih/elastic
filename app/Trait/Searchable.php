<?php

namespace App\Trait;

use App\Observers\ElasticSearchObserver;

trait Searchable
{
    public static function bootSearchable()
    {
        if (config('services.search.enabled'))
            static::observe(ElasticSearchObserver::class);
    }
    /**
     * Get search index
     *
     * @return string
     */
    public function getSearchIndex()
    {
        return $this->getTable();
    }
    /**
     * Get search type
     *
     * @return string
     */
    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType'))
            return $this->useSearchType;

        return $this->getTable();
    }
    /**
     * To search array
     *
     * @return array
     */
    public function toSearchArray()
    {
        return $this->toArray();
    }
}
