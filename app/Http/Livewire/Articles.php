<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Repository\ArticleRepository;
use App\Repository\Queries\Interfaces\FilterType;
use App\Repository\Queries\Interfaces\LogicOperator;
use App\Repository\SearchRepository;
use Carbon\Carbon;
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
        /* Поиск по названию с кастомным анализатором, который разбивыет каждое слово на n-граммы */
        $this->repository->searchable()->logicTermMatch("title", $this->requires["search"]["multisearch"] ?? "", LogicOperator::LOGIC_OPERATOR_FOR_TERM_OR, LogicOperator::LOGIC_OPERATOR_AND);
        /* Поиск по user_id */
        $this->repository->searchable()->termMultiMatch("user_id", $this->requires["filter"]["users_id"] ?? []);
        /* Поиск по tag_id */
        $this->repository->searchable()->termMultiMatch("tags", $this->requires["filter"]["tags_id"] ?? []);
        /* Фильтр по дате */
        $this->repository->filter()->moreOrEqual("created_at", $this->requires["filter"]["date_before"] ?? "", FilterType::FILTER_TYPE_DATE);
        /* Фильтр по дате */
        $this->repository->filter()->lessOrEqual("created_at", $this->requires["filter"]["date_after"] ?? "", FilterType::FILTER_TYPE_DATE);

        return $this->repository->get();
    }
    public function render()
    {
        return view('livewire.articles', [
            "articles" => $this->getItems(),
            "users" => User::all(),
            "tags" => Tag::all()
        ]);
    }
}
