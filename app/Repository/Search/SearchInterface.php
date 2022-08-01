<?php

namespace App\Repository\Search;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SearchInterface
{
    /**
     * Search
     *
     * @param Model $model
     * @param string $query
     * @param string $searchables
     * @return Collection
     */
    public function search(string $query = "", Model $model, string $searchable = ""): Collection;
    /**
     * Multi search
     *
     * @param string $query
     * @param Model $model
     * @param array $searchables
     * @return Collection
     */
    public function multiSearch(string $query = "", Model $model, array $searchables = []): Collection;
}
