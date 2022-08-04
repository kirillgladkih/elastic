<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\User;
use App\Repository\ArticleRepository;
use Livewire\Component;
use Spatie\ElasticsearchQueryBuilder\Builder as ElasticsearchQueryBuilderBuilder;
use Spatie\ElasticsearchQueryBuilder\Queries\BoolQuery;
use Spatie\ElasticsearchQueryBuilder\Queries\MatchQuery;

class Articles extends Component
{
    public $search = "";

    protected $repository;

    public function __construct()
    {
        $this->repository = new ArticleRepository();
    }

    public function getItems()
    {
        dd(Article::where("id", "1"));

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
