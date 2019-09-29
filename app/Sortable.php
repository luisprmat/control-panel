<?php

namespace App;

use Illuminate\Support\{Arr, Str};

class Sortable
{
    protected $currentUrl;
    protected $query = [];

    public function __construct($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public static function info($order)
    {
        if (Str::endsWith($order, '-desc')) {
            return [Str::substr($order, 0, -5), 'desc'];
        } else {
            return [$order, 'asc'];
        }
    }

    public function appends(array $query)
    {
        $this->query = $query;
    }

    protected function buildSortableUrl($order)
    {
        return $this->currentUrl.'?'.Arr::query(array_merge($this->query, ['order' => $order]));
    }

    protected function isSortingBy($column)
    {
        return Arr::get($this->query, 'order') == $column;
    }

    public function classes($column)
    {
        if ($this->isSortingBy($column)) {
            return 'fa-sort-up';
        }

        if ($this->isSortingBy("{$column}-desc")) {
            return 'fa-sort-down';
        }

        return 'fa-sort';
    }

    public function url($column)
    {
        if($this->isSortingBy($column)) {
            return $this->buildSortableUrl("{$column}-desc");
        }

        return $this->buildSortableUrl($column);
    }
}
