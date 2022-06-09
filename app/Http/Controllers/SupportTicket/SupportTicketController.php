<?php

namespace App\Http\Controllers\SupportTicket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Lenses\SupportTicket\OrderByDate;
use App\Http\Filters\SupportTicket\StatusFilter;
use App\Http\Requests\SupportTicket\CreateSupportTickerRequest;
use App\Models\SupportTicket;
use App\Notifications\SupportTicketCreated;
use App\Services\SupportTicket\SupportTicketReplyService;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupportTicketController extends Controller
{
    public function index()
    {
        $query = app(Pipeline::class)
            ->send(SupportTicket::query())
            ->through([
                StatusFilter::class,
                OrderByDate::class,
            ])
            ->thenReturn();

        $tickets = $query->withCount('replies')
            ->orderBy('replies_count', 'asc')
            ->paginate()
            ->withQueryString();

        return view('support-ticket.index', ['tickets' => $tickets]);
    }

    public function show(int|string $supportTicketId)
    {
        if (is_numeric($supportTicketId)) {
            $supportTicket = SupportTicket::find($supportTicketId);
        } else {
            $supportTicket = SupportTicket::where('reference_id', $supportTicketId)->first();
        }

        throw_unless($supportTicket, new NotFoundHttpException());

        SupportTicketReplyService::updateTicketStatusToViewed($supportTicket);

        return view('support-ticket.show-ticket-form', ['ticket' => $supportTicket]);
    }

    public function createSearchByRefId()
    {
        return view('support-ticket.search-by-refId');
    }

    public function create()
    {
        return view('support-ticket.create-ticket-form');
    }

    public function store(CreateSupportTickerRequest $request)
    {
        $inputs = $request->validated();

        $newTicket = new SupportTicket($inputs);

        $newTicket->save();

        Notification::route('mail', [$inputs['email'] => $inputs['name']])
            ->notify(new SupportTicketCreated($newTicket->getAttribute('reference_id')));

        $request->session()->flash('status', ['type' => 'success', 'message' => __('success.support_ticket_created')]);

        return back();
    }

    public function search(Request $request)
    {
        $request->validate(['value' => ['required', 'string', 'max:255']]);

        $value = $request->value;

        $tickets = SupportTicket::query()
            ->search($value)
            ->withCount('replies')
            ->paginate()
            ->withQueryString();

        if ($tickets->empty()) {
            return view('support-ticket.index', ['tickets' => $tickets, 'type' => 'search']);
        }

        return view('support-ticket.index', ['tickets' => $tickets]);
    }

    public function searchByRefId(Request $request)
    {
        $request->validate(['value' => ['required', 'string', 'max:255']]);

        $value = $request->value;

        $tickets = SupportTicket::query()
            ->where('reference_id', $value)
            ->withCount('replies')
            ->paginate();

        return view('support-ticket.index', ['tickets' => $tickets, 'type' => 'search']);
    }
}
