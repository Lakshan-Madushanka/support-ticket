<?php

namespace App\Http\Filters\SupportTicket;

use App\Models\SupportTicket;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter
{
    public function handle(Builder $query, \Closure $next)
    {
        request()->whenFilled('status', function () use ($query, $next) {
            if (in_array(request()->query('status'), SupportTicket::STATUS)) {
                $query->whereStatus((int)\request()->query('status'));
            }
        });

        return $next($query->orderBy('status', 'asc'));
    }
}
