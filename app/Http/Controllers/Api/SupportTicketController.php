<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupportTicketResource;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupportTicketController extends Controller
{
    public function searchByRefId(Request $request)
    {
        $request->validate(['value' => [
            'required',
            'string',
            Rule::exists('support_tickets', 'reference_id'),
            ]]);

        $value = $request->value;

        $ticket = SupportTicket::query()
            ->where('reference_id', $value)
            ->withCount('replies')
            ->first();


        return new SupportTicketResource($ticket);
    }
}
