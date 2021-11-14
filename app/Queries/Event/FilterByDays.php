<?php

namespace App\Queries\Event;

class FilterByDays
{
    public function handle($query, $next)
    {
        if(request()->has('days')) {
            $query->whereJsonContains('days', explode(',', request('days')));
        }
        return $next($query);
    }
}
