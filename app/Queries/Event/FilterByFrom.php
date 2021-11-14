<?php

namespace App\Queries\Event;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByFrom
{
    public function handle(Builder $query, Closure $next)
    {
        if(request()->has('from')) {
            $query->whereDate('from', request('from'));
        }
        return $next($query);
    }
}
