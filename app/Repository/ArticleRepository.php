<?php

namespace App\Repository;

use App\Models\Article;
use App\Repository\Search\Elastic;
use App\Repository\Search\SearchInterface;
use Illuminate\Database\Eloquent\Model;

class ArticleRepository extends ARepository
{
    /**
     * Get model instanse
     *
     * @return Model
     */
    protected function start(): Model
    {
        return new Article();
    }
    /**
     * Get search searvice
     *
     * @return SearchInterface
     */
    protected function getSearchService(): SearchInterface
    {
        return new Elastic(resolve(\Elastic\Elasticsearch\Client::class));
    }
}
