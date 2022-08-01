<?php

namespace App\Models\ModelTrait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

trait IdQueryTrait
{
    /**
     * Find an item by its id
     *
     * @param Builder $query
     * @param Integer $id
     * @return Builder
     */
    public function scopeFindById($query, $id)
    {
        return $query->where("id", $id);
    }

    /**
     * Find list items by a list of Id
     *
     * @param Builder $query
     * @param array(Integer) $idList
     * @return Builder
     */
    public function scopeFindByIds(Builder $query, $idList)
    {
        return $query->whereIn("id", $idList);
    }
}
