<?php

namespace App\Http\Controllers\Reply;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index()
    {
        $replies = Reply::paginate(10);


        return view('reply.index', ['replies' => $replies]);
    }

    public function show(Reply $reply)
    {
        $this->addRepliedAtAttribute($reply);

        return view('reply.show-reply-form', ['reply' => $reply]);
    }

    public function showByRefId(int $replyId, string $referenceId)
    {
        $reply = Reply::query()
            ->whereHas('supportTickets', function ($query) use ($referenceId) {
                $query->where('support_tickets.reference_id', $referenceId);
            })
            ->where('id', $replyId)
            ->first();

        $this->addRepliedAtAttribute($reply);


        return view('reply.show-reply-form', ['reply' => $reply, 'referenceId' => $referenceId]);
    }

    public function search(Request $request)
    {
        $validatedInputs = $request->validate([
            'value' => ['required', 'string',],
        ]);

        $value = $validatedInputs['value'];

        $results = Reply::query()
            ->whereId((int) $value)
            ->orWhereFullText('content', $value)
            ->latest()
            ->paginate();

        return view('reply.index', ['replies' => $results, 'query' => $value]);
    }

    public function addRepliedAtAttribute(Reply $reply)
    {
        if (\request()->query('type') === 'ticketReplies') {
            $reply->setAttribute('replied_at', \request()->query('replied_at'));
        }
    }
}
