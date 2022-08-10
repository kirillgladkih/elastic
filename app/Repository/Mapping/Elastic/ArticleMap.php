<?php

namespace App\Repository\Mapping\Elastic;

use App\Models\Article;
use App\Repository\Mapping\Elastic\Interfaces\ElasticMap;
use App\Repository\Mapping\Map;
use Illuminate\Database\Eloquent\Model;

class ArticleMap extends Map implements ElasticMap
{
    /**
     * Get index
     *
     * @return string
     */
    public function index(): string
    {
        return "articles";
    }
    /**
     * Get type
     *
     * @return string
     */
    public function type(): string
    {
        return "articles";
    }
    /**
     * Get model name
     *
     * @return string
     */
    public function model(): string
    {
        return Article::class;
    }
    /**
     * Get setting
     *
     * @return array
     */
    public function settings(): array
    {
        return [
            "analysis" => [
                "analyzer" => [
                    'autocomplete' => [
                        'tokenizer' => 'autocomplete',
                        'filter' =>[
                            'lowercase',
                            'asciifolding'
                        ],
                    ],
                    'autocomplete_search' => [
                        'tokenizer' => 'lowercase',
                    ]
                ],
                "tokenizer" => [
                    "autocomplete"=> [
                        "type"=> "edge_ngram",
                        "min_gram"=> 1,
                        "max_gram"=> 10,
                        "token_chars" => [
                            "letter",
                            "digit"
                        ]
                    ],
                ],
            ]
        ];
    }
    /**
     * Get map
     *
     * @return array
     */
    public function map(): array
    {
        return [
            "title" => [
                "type" => "text",
                "analyzer" =>  "autocomplete",
                "search_analyzer" =>  "autocomplete_search"
            ],
            "body" => [
                "type" => "text"
            ],
            "id" => [
                "type" => "long"
            ],
            "tags" => [
                "type" => "keyword"
            ],
            "user_name" => [
                "type" => "text"
            ],
            "user_id" => [
                "type" => "long"
            ],
            "created_at" => [
                "type" => "date"
            ],
            "updated_at" => [
                "type" => "date"
            ]
        ];
    }
    /**
     * Model
     *
     * @param Model $model
     * @return array
     */
    public function source(Model $model): array
    {
        $attr = $model->attributesToArray();

        $tagsCollection = $model->tags();

        foreach($tagsCollection as $tag)
            $tags[] = $tag->name;

        return [
            "title" => $attr["title"],
            "body" => $attr["body"],
            "id" => $attr["id"],
            "tags" => $attr["tags"],
            "user_name" => $model->user()->first()->name ?? "NULL",
            "user_id" => $model->user()->first()->id ?? "NULL",
            "created_at"=> $attr["created_at"] ?? "NULL",
            "updated_at"=> $attr["updated_at"] ?? "NULL"
        ];
    }
}
