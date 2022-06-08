<?php

namespace App\Services\SupportTicket;

use App\Models\SupportTicket;

class SupportTicketService
{
    public static function formatDescription(string $description): string
    {
        if (strlen($description) > 20) {
            return substr($description, 0, 20).'...';
        }

        return $description;
    }

    public static function statusTextfromCode(int $code): string
    {
        return array_search($code, SupportTicket::STATUS);
    }

    public static function isStatus(int $code): bool
    {
        return array_search($code, SupportTicket::STATUS);
    }

    public static function priorityTextFromCode($code)
    {
        return array_search($code, SupportTicket::PRIORITY);
    }

    public static function priorityCssClass($code)
    {
        $class = 'badge rounded-pill bg-';

        return match ($code) {
            SupportTicket::PRIORITY['HIGH'] => $class.'danger',
            SupportTicket::PRIORITY['MEDIUM'] => $class.'warning',
            SupportTicket::PRIORITY['LOW'] => $class.'info',
        };
    }
}
