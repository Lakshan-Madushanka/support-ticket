<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reply;

class ReplyController extends Controller
{
    public function show(Reply $reply)
    {
        return $reply;
    }
}
