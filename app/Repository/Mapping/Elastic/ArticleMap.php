<?php

namespace App\Repository\Mapping\Elastic;

use App\Models\Article;
use App\Repository\Mapping\Elastic\Interfaces\ElasticMap;
use App\Repository\Mapping\Map;
use Illuminate\Database\Eloquent\Model;

class ArticleMap extends Map implements ElasticMap
{
    public function index(): string
    {
        return "articles";
    }

    public function type(): string
    {
        return "articles";
    }

    public function map(): array
    {
        return [
            "title" => ["type" => self::MAP_TYPE_TEXT],
            "body" => ["type" => self::MAP_TYPE_TEXT],
        ];
    }

    public function source(): array
    {
        return [];
    }
}
