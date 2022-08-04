<?php

namespace App\Repository\Mapping;

use Illuminate\Database\Eloquent\Model;

/**
 * This abstract map class
 */
abstract class Map
{
    /**
     * To array map
     *
     * @return array
     */
    abstract function map(): array;
}
