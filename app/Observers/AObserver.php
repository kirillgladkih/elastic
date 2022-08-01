<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class AObserver
{
    /**
     * Creating hook
     *
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        //
    }
    /**
     * Updating hook
     *
     * @param Model $model
     * @return void
     */
    public function updated(Model $model)
    {
        //
    }
    /**
     * Deleting hook
     *
     * @param Model $model
     * @return void
     */
    public function deleted(Model $model)
    {
        //
    }
    /**
     * Restoging hook
     *
     * @param Model $model
     * @return void
     */
    public function restored(Model $model)
    {
        //
    }
    /**
     * Force deliting hook
     *
     * @param Model $model
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        //
    }
}
