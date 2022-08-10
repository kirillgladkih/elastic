<?php

namespace App\Repository\Mapping\Elastic\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ElasticMap
{
    /**
     * Get settings
     *
     * @return array
     */
    public function settings(): array;
    /**
     * Get index
     *
     * @return string
     */
    public function index(): string;
    /**
     * Get type
     *
     * @return string
     */
    public function type(): string;
    /**
     * Model class
     *
     * @return string
     */
    public function model(): string;
    /**
     * Get map
     *
     * @return array
     */
    public function map(): array;
    /**
     * Get source for document
     *
     * @param Model model
     * @return array
     */
    public function source(Model $model): array;
}
