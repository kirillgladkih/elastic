<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\User;
use App\Repository\ArticleRepository;
use Livewire\Component;

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
        $query = !empty($this->search)
            ? $this->repository->search($this->search, "tags")
            : $this->repository->all();

        return $query->paginate(200);

    }
    public function render()
    {
        return view('livewire.articles', [
            "articles" => $this->getItems(),
            "users" => User::all()
        ]);
    }
}
