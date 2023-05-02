<?php
namespace App\QueryBuilder\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\FiltersExact;

class FiltersUserOrEmail extends FiltersExact
{
    public function __invoke(Builder $query, $value, string $property)
    {
        collect(['name', 'email'])->each(function($param) use (&$query, $value) {
            $sql = "LOWER({$param}) LIKE ?";
            $partialValue = mb_strtolower($value, 'UTF8');

            $query->orWhereRaw($sql, ["%{$partialValue}%"]);
        });

    }
}
