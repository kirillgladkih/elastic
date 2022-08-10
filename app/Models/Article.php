<?php

namespace App\Models;

use App\Models\Interfaces\ISearchable;
use App\Trait\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model implements ISearchable
{
    use HasFactory, Searchable;
    /**
     * Searchables fields
     *
     * @var array
     */
    public static $searchables = [
        "title",
        "body",
        "tags"
    ];
    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        "tags" => "json"
    ];
    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get tags
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function tags()
    {
        $tags = $this->tags ?? [];

        return Tag::whereIn("id", $tags)->get();
    }

    public function toSearchArray()
    {
        $data = $this->toArray();

        foreach($this->user()->first()->toArray() as $key => $value)
            $data["user_" . $key] = $value;

        return $data;
    }
    /**
     * Get mapping
     *
     * @return array
     */
    public function getMapp(): array
    {
        return [];
    }
}
