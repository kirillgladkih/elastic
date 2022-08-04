<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Abstract repository class
 */
abstract class ARepository
{
    /**
     * Get model instance
     *
     * @return Model
     */
    abstract protected function start(): Model;
    /**
     * This query builder
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected \Illuminate\Database\Eloquent\Builder $builder;
    /**
     * Init
     */
    public function __construct()
    {
        $this->builder = $this->start()->where("id", ">", "0");
    }
    /**
     * Replace builder
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \App\Repository\ARepository
     */
    public function replaceBuilder(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $this->builder = $builder;

        return $this;
    }
    /**
     * Get collection result
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(): \Illuminate\Support\Collection
    {
        return $this->builder->get();
    }
}
