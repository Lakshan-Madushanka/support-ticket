<?php

namespace App;

use Illuminate\Support\Facades\Gate;

class helpers
{
    public static function getLayout(): string
    {
        return Gate::allows('supportAgent')
            ? 'layouts.dashboard' : 'layouts.main';
    }
}
