<?php

namespace App\Http\Requests;

use App\Rules\SupportTicket\CurrentStatusValidateRule;
use App\Services\SupportTicket\SupportTicketReplyService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupportTicketRepliedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'status' => [
                'required',
                'integer',
                new CurrentStatusValidateRule($this->supportTicket->status),
                Rule::in(SupportTicketReplyService::availableReplyStatus()),
            ],
        ];

        if ($this->routeIs('support-ticket.reply.store')) {
            $rules['reply'] = ['required_unless:status,4', 'nullable', 'string', 'min:5'];
        } elseif ($this->routeIs('support-ticket.reply.assign')) {
            $rules['replyId'] = ['required', 'integer'];
        }

        return $rules;
        /* return [
             'reply'  => ['required_unless:status,4', 'nullable', 'string', 'min:5'],
             'status' => [
                 'required',
                 'integer',
                 new CurrentStatusValidateRule($this->supportTicket->status),
                 Rule::in(SupportTicketReplyService::availableReplyStatus())
             ],
             'reply_id' => ['required', 'integer']
         ];*/
    }

    public function messages()
    {
        return [
            'reply.required_unless' => "The content field is required unless status is in Rejected.",
        ];
    }
}
