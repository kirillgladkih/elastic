<?php

namespace App\Repository;

use App\Repository\Search\SearchInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Abstract repository class
 */
abstract class ARepository
{
    /**
     * Get model instance
     *
     * @return Model
     */
    abstract protected function start(): Model;
    /**
     * Get search service
     *
     * @return SearchInterface
     */
    abstract protected function getSearchService(): SearchInterface;
    /**
     * Get all
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function all(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->start()->where("id", ">", "0");
    }
    /**
     * Multi search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function multiSearch(string $query = "")
    {
        $items = $this->getSearchService()
            ->multiSearch($query, $this->start(), $this->start()::$searchables ?? []);

        foreach ($items as $item)
            $ids[] = $item["id"];

        return $this->start()->whereIn("id", $ids ?? []);
    }
    /**
     * Search
     *
     * @param string $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function search(string $query = "", string $searchable = "")
    {
        $items = $this->getSearchService()
            ->search($query, $this->start(), $searchable);

        foreach ($items as $item)
            $ids[] = $item["id"];

        return $this->start()->whereIn("id", $ids ?? []);
    }
}
