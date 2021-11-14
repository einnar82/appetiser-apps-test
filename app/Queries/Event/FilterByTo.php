<?php

namespace App\Queries\Event;

class FilterByTo
{
    public function handle($query, $next)
    {
        if(request()->has('to')) {
            $query->whereDate('to', request('to'));
        }
        return $next($query);
    }
}
