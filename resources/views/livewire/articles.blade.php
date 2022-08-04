<div class="container">
    <div class="card">
        <h5 class="card-header text-center">Articles {{ count($articles) }}</h5>
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-12 mb-3">
                    <input type="text" wire:model="requires.search.multisearch" class="form-control" placeholder="search">
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Сортировка по пользователю</label>
                    <select class="form-select" wire:model="requires.filter.user_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name . " " . $user->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @foreach ($articles as $article)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $article->title . " " . $article->id }}</h5>
                        @if (count($article->tags) > 0)
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @foreach ($article->tags as $tag)
                                        <li class="breadcrumb-item" aria-current="page">{{ $tag }}</li>
                                    @endforeach
                                </ol>
                            </nav>
                        @endif
                        <p>{{ $article->body }}</p>
                        <p>Author: {{ $article->user->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
