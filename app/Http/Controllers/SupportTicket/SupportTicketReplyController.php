<?php

namespace App\Http\Controllers\SupportTicket;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketRepliedRequest;
use App\Models\Reply;
use App\Models\SupportTicket;
use App\Services\SupportTicket\SupportTicketReplyService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SupportTicketReplyController extends Controller
{
    public function create(string $id)
    {
        $ticket = SupportTicket::find($id);

        SupportTicketReplyService::updateTicketStatusToViewed($ticket);

        return view('support-ticket.create-reply-form', ['id' => $id]);
    }

    public function store(SupportTicketRepliedRequest $request, SupportTicket $supportTicket)
    {
        $inputs = $request->validated();
        $currentStastus = $supportTicket->status;
        $newStatus = (int) $inputs['status'];

        DB::beginTransaction();

        try {
            retry(3, function () use ($inputs, $supportTicket, $newStatus) {
                if ($newStatus !== SupportTicket::STATUS['REJECTED']) {
                    SupportTicketReplyService::saveReply($inputs, $supportTicket);
                } elseif (! empty($inputs['reply']) && $newStatus == SupportTicket::STATUS['REJECTED']) {
                    SupportTicketReplyService::saveReply($inputs, $supportTicket);
                }
                SupportTicketReplyService::updateTicketStatus($supportTicket, $newStatus);
            }, 100);
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            $request->session()->flash(
                'status',
                ['type' => 'danger', 'message' => 'Error occurred please try again shortly !']
            );

            return back();
        }

        SupportTicketReplyService::sendRepliedNotificationByStatus($supportTicket);

        return SupportTicketReplyService::redirectAfterSuccess($supportTicket, $request);
    }

    public function show(int $supportTicketId)
    {
        $replies = Reply::query()->byId($supportTicketId)->latest()->paginate();

        return view('reply.index', ['replies' => $replies]);
    }

    public function searchByRefId(int $supportTicketIId, string $refId)
    {
        $replies = Reply::query()
            ->byRefId($refId)
            ->latest()
            ->paginate();

        return view('reply.index', ['replies' => $replies]);
    }

    public function createAssignReply(SupportTicket $supportTicket)
    {
        SupportTicketReplyService::updateTicketStatusToViewed($supportTicket);

        $ticketIds = Reply::pluck('id');

        return view('support-ticket.assign-reply-form', ['id' => $supportTicket->id, 'replyIds' => $ticketIds]);
    }

    public function assign(SupportTicket $supportTicket, SupportTicketRepliedRequest $request)
    {
        $inputs = $request->validated();
        $newStatus = $inputs['status'];

        $supportTicket->replies()->attach([$inputs['replyId']]);

        SupportTicketReplyService::updateTicketStatus($supportTicket, $newStatus);

        SupportTicketReplyService::sendRepliedNotificationByStatus($supportTicket);

        return SupportTicketReplyService::redirectAfterSuccess($supportTicket, $request);
    }
}
