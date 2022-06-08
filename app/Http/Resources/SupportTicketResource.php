<?php

namespace App\Http\Resources;

use App\Services\SupportTicket\SupportTicketService;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'description' => SupportTicketService::formatDescription($this->description),
            'status' => SupportTicketService::statusTextfromCode($this->status),
            'created_at' => $this->created_at->toDayDateTimeString(),
            'phone_number' => $this->phone_number,
            'reference_id' => $this->reference_id,
            'replies_count' => $this->replies_count,
        ];
    }
}
