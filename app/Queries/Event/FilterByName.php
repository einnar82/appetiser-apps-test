<?php

namespace App\Queries\Event;

use Closure;
use Illuminate\Database\Eloquent\Builder;
class FilterByName
{
    public function handle(Builder $query, Closure $next)
    {
        if(request()->has('title')) {
            $query->where('title', request('title'));
        }
        return $next($query);
    }
}
