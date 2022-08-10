<div class="container">
    <div class="card">
        <h5 class="card-header text-center">Articles {{ count($articles) }}</h5>
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-12 mb-3">
                    <input type="text" wire:model="requires.search.multisearch" class="form-control" placeholder="search">
                </div>
                <div class="col-12 mb-3">
                    <label for="" class="form-label">Сортировка по пользователю</label>
                    <select class="form-select" wire:model="requires.filter.users_id" multiple>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="" class="form-label">Сортировка по тегам</label>
                    <select class="form-select" wire:model="requires.filter.tags_id" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Дата от</label>
                    <input type="date" wire:model="requires.filter.date_before" class="form-control">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Дата до</label>
                    <input type="date" wire:model="requires.filter.date_after" class="form-control">
                </div>
            </div>
            @foreach ($articles as $article)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $article->title . " " . $article->id }}</h5>
                        @if (count($article->tags) > 0)
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @foreach ($article->tags() as $tag)
                                        <li class="breadcrumb-item" aria-current="page">{{ $tag->name }}</li>
                                    @endforeach
                                </ol>
                            </nav>
                        @endif
                        <p>{{ $article->body }}</p>
                        <p>Author: {{ $article->user->name }}</p>
                        <p>Created: {{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d')}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
