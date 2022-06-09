<?php

namespace App\Http\Controllers\Lenses\SupportTicket;

use Illuminate\Database\Eloquent\Builder;

class OrderByDate
{
    public function handle(Builder $query, \Closure $next)
    {
        request()->whenFilled('orderByDate', function () use ($query, $next) {
            $query->orderBy('id', request()->query('orderByDate'));
        });

        return $next($query->orderBy('created_at', 'desc'));
    }
}
