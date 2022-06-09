<?php

namespace App\Models;

use App\Services\SupportTicket\SupportTicketService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class SupportTicket extends Model
{
    use HasFactory;

    public const STATUS = [
        'PENDING' => 0,
        'VIEWED' => 1,
        'REPLIED' => 2,
        'ENDED' => 3,
        'REJECTED' => 4,
    ];

    public const PRIORITY = [
        'LOW' => 0,
        'MEDIUM' => 1,
        'HIGH' => 2,
    ];

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (SupportTicket $ticket) {
            $ticket->setAttribute('reference_id', Str::uuid());
        });
    }

    public function scopeSearch(Builder $query, $value): Builder
    {
        return $query->where('name', 'like', "%$value%")
            ->orWhere('email', $value)
            ->orWhere('reference_id', $value);
    }

    public function replies(): BelongsToMany
    {
        return $this->belongsToMany(Reply::class, 'support_ticket_reply')
            ->withTimestamps()
            ->withPivot('created_at');
    }

    // mutators and accessors
    public function description(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return SupportTicketService::formatDescription($value);
            }
        );
    }

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $value = $this->status;
                return SupportTicketService::statusTextfromCode($value);
            }
        );
    }

    public function isPending(): Attribute
    {
        return Attribute::make(
            get: function () {
                $value = $this->getRawOriginal('status');
                return $value == SupportTicket::STATUS['PENDING'];
            }
        );
    }

    public function isViewed(): Attribute
    {
        return Attribute::make(
            get: function () {
                $value = $this->getRawOriginal('status');
                return $value == SupportTicket::STATUS['VIEWED'];
            }
        );
    }

    public function replyStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                $value = $this->getRawOriginal('status');
                if ($value == SupportTicket::STATUS['ENDED'] ||
                $value == SupportTicket::STATUS['REJECTED']) {
                    return 'Closed';
                } else {
                    return 'reply';
                }
            }
        );
    }
}
