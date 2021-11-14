<?php

namespace App\Queries\Event;

class FilterByName
{
    public function handle($query, $next)
    {
        if(request()->has('title')) {
            $query->where('title', request('title'));
        }
        return $next($query);
    }
}
