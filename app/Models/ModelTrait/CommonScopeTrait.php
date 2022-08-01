<?php

namespace App\Models\ModelTrait;

use Illuminate\Database\Eloquent\Builder;

trait CommonScopeTrait
{
    public static $activatedStatusMarker = 'STATUS_ACTIVATED';
    public static $deactivatedStatusMarker = 'STATUS_DEACTIVATED';
    public static $deletedStatusMarker = 'STATUS_DELETED';
    public static $hiddenStatusMarker = 'STATUS_HIDDEN';

    public function scopeStatus(Builder $query, $statusMarker)
    {
        $status = constant("self::$statusMarker");
        return $query->where("status", $status);
    }

    public function scopeActivated($query)
    {
        return $this->status(self::$activatedStatusMarker);
    }

    public function scopeDeactivated($query)
    {
        return $this->status(self::$deactivatedStatusMarker);
    }

    public function scopeNotDeleted($query)
    {
        $statusMarker = self::$deletedStatusMarker;
        $status = constant("self::$statusMarker");
        return $query->where("status", "<>", $status);
    }

    public function scopeNotHidden($query)
    {
        $statusMarker = self::$hiddenStatusMarker;
        $status = constant("self::$statusMarker");
        return $query->where("status", "<>", $status);
    }

    public function scopeWhereLike($query, $columns, $value)
    {
        if (!is_array($columns)){
            $columns = [$columns];
        }

        $firstColumn = array_shift($columns);
        $query = $query->where($firstColumn, 'like', '%' . $value . '%');

        foreach ($columns as $column){
            $query = $query->orWhere($column, 'like', '%' . $value . '%');
        }

        return $query;
    }
}
