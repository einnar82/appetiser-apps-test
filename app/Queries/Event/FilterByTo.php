<?php

namespace App\Queries\Event;

use Closure;
use Illuminate\Database\Eloquent\Builder;
class FilterByTo
{
    public function handle(Builder $query, Closure $next)
    {
        if(request()->has('to')) {
            $query->whereDate('to', request('to'));
        }
        return $next($query);
    }
}
