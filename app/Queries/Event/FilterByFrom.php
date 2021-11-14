<?php

namespace App\Queries\Event;

class FilterByFrom
{
    public function handle($query, $next)
    {
        if(request()->has('from')) {
            $query->whereDate('from', request('from'));
        }
        return $next($query);
    }
}
