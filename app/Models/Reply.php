<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function supportTickets(): BelongsToMany
    {
        return $this->belongsToMany(SupportTicket::class, 'support_ticket_reply')
            ->withTimestamps();
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Carbon::parse($value)->toDayDateTimeString();
            }
        );
    }

    public function content(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (strlen($value) > 50) {
                    return substr($value, 0, 25).'...';
                }

                return $value;
            }
        );
    }

    // Query scopes
    public function scopeByRefId(Builder $query, string $refId)
    {
        return $query->join('support_ticket_reply', 'replies.id', '=', 'support_ticket_reply.reply_id')
            ->join('support_tickets', 'support_tickets.id', '=', 'support_ticket_reply.support_ticket_id')
            ->where('support_tickets.reference_id', $refId)
            ->select('replies.id', 'content', 'support_ticket_reply.created_at');
    }

    public function scopeById(Builder $query, int $id)
    {
        return $query->join('support_ticket_reply', 'replies.id', '=', 'support_ticket_reply.reply_id')
            ->join('support_tickets', 'support_tickets.id', '=', 'support_ticket_reply.support_ticket_id')
            ->where('support_tickets.id', $id)
            ->select('replies.id', 'content', 'support_ticket_reply.created_at');
    }
}
