<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\User;
use App\Repository\ArticleRepository;
use App\Repository\Queries\Interfaces\LogicOperator;
use App\Repository\SearchRepository;
use Elastic\Elasticsearch\Transport\Adapter\Guzzle;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Http;
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
        // $response = Http::get("https://p2p.binance.com/ru/trade/sell/SHIB?fiat=RUB&payment=Tinkoff");
        // dd($response->body());
        $this->repository->searchable()->logicTermMatch("title", $this->requires["search"]["multisearch"] ?? "", LogicOperator::LOGIC_OPERATOR_FOR_TERM_OR);
        // $this->repository->searchable()->termMatch("title",$this->requires["search"]["multisearch"] ?? "", LogicOperator::LOGIC_OPERATOR_OR);
        // $this->repository->searchable()->termMatch("title",$this->requires["search"]["multisearch"] ?? "", LogicOperator::LOGIC_OPERATOR_OR);
        // $this->repository->searchable()->termMatch("user_id", strtolower($this->requires["filter"]["user_id"] ?? ""));
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
