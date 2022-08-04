<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\User;
use App\Repository\ArticleRepository;
use App\Repository\Queries\Interfaces\LogicOperator;
use App\Repository\SearchRepository;
use Livewire\Component;
use Spatie\ElasticsearchQueryBuilder\Builder as ElasticsearchQueryBuilderBuilder;
use Spatie\ElasticsearchQueryBuilder\Queries\BoolQuery;
use Spatie\ElasticsearchQueryBuilder\Queries\MatchQuery;

class Articles extends Component
{
    protected $repository;

    public $requires = [];

    public function __construct()
    {
        $this->repository = new SearchRepository(new Article());
    }

    public function getItems()
    {
        $this->repository->searchable()->fullTextMultiMatch(["title", "user_name"], strtolower($this->requires["search"]["multisearch"] ?? ""));
        $this->repository->searchable()->termMatch("user_id", strtolower($this->requires["filter"]["user_id"] ?? ""));
        return $this->repository->get();
        // $this->repository->get();

        // // // $query = !empty($this->search)
        // // //     ? $this->repository->search($this->search, "tags")
        // // //     : $this->repository->all();
        // // $client = resolve(\Elastic\Elasticsearch\Client::class);

        // // $response = $client->search([
        // //             'index' => "articles",
        // //             'type' => "articles",
        // //             // 'size' => "100",
        // //             'body' => [
        // //             ],
        // //         ]);

        // // dd($response["hits"]);

        // // $query =  $this->repository->all();

        // // return $query->paginate(200);

    }
    public function render()
    {
        return view('livewire.articles', [
            "articles" => $this->getItems(),
            "users" => User::all(),
        ]);
    }
}
