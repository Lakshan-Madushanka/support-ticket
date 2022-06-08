<?php

namespace App\Services\SupportTicket;

use App\Models\Reply;
use App\Models\SupportTicket;
use App\Notifications\SupportTicketReplied;
use App\Notifications\SupportTicketViewed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SupportTicketReplyService
{
    public static function updateTicketStatusToViewed(SupportTicket $ticket)
    {
        if ($ticket->status === SupportTicket::STATUS['PENDING']) {
            $ticket->update(['status' => SupportTicket::STATUS['VIEWED']]);

            self::sendTicketViewedNotification($ticket);
        }
    }

    public static function updateTicketStatus(SupportTicket $supportTicket, int $newStatus)
    {
        $supportTicket->fill(['status' => $newStatus]);

        if ($supportTicket->isDirty('status')) {
            $supportTicket->update();
        }
    }

    public static function sendTicketViewedNotification(SupportTicket $ticket)
    {
        Notification::route('mail', [$ticket->email => $ticket->mail])
            ->notify(new SupportTicketViewed($ticket->reference_id));
    }

    public static function saveReply(array $inputs, SupportTicket $supportTicket)
    {
        $reply = Reply::create(['content' => $inputs['reply']]);
        $supportTicket->replies()->attach([$reply->id]);
    }

    public static function sendSupportTicketRepliedNotification(SupportTicket $supportTicket, string $msg = '')
    {
        $notification = Notification::route('mail', [$supportTicket->email => $supportTicket->name]);

        $msg ? $notification->notify(new SupportTicketReplied($supportTicket->reference_id, $msg))
             : $notification->notify(new SupportTicketReplied($supportTicket->reference_id));
    }

    public static function availableReplyStatus()
    {
        return array_slice(\App\Models\SupportTicket::STATUS, 2);
    }

    public static function sendRepliedNotificationByStatus(SupportTicket $supportTicket)
    {
        if ($supportTicket->status === SupportTicket::STATUS['REJECTED']) {
            $msg = 'Following support ticket has been rejected due to violate our terms and conditions';
            self::sendSupportTicketRepliedNotification($supportTicket, $msg);
        } elseif ($supportTicket->status === SupportTicket::STATUS['ENDED']) {
            $msg = 'Following support ticket ended. You are no longer be replied';
            self::sendSupportTicketRepliedNotification($supportTicket, $msg);
        } else {
            self::sendSupportTicketRepliedNotification($supportTicket);
        }
    }

    public static function redirectAfterSuccess(SupportTicket $supportTicket, Request $request)
    {
        $message = 'Ticket '.strtolower(SupportTicketService::statusTextfromCode($supportTicket->status)).
            ' successfully !';

        $request->session()->flash('status', ['type' => 'success', 'message' => $message]);

        if ($supportTicket->status !== SupportTicket::STATUS['REPLIED']) {
            return redirect()->route('dashboard');
        }

        return back();
    }
}
