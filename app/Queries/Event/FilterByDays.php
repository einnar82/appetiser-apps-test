<?php

namespace App\Queries\Event;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByDays
{
    public function handle(Builder $query, Closure $next)
    {
        if(request()->has('days')) {
            $query->whereJsonContains('days', explode(',', request('days')));
        }
        return $next($query);
    }
}
