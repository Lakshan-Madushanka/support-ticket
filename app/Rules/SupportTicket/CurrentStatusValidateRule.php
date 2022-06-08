<?php

namespace App\Rules\SupportTicket;

use App\Models\SupportTicket;
use Illuminate\Contracts\Validation\Rule;

class CurrentStatusValidateRule implements Rule
{
    private static $errorMsg = [
        SupportTicket::STATUS['ENDED'] => 'Cannot reply to ended ticket !',
        SupportTicket::STATUS['PENDING'] => 'Cannot reply to pending ticket !',
        SupportTicket::STATUS['REJECTED'] => 'Cannot reply to rejected ticket !',
    ];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private int $currentStatus)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = $this->currentStatus;

        return match ($value) {
            SupportTicket::STATUS['ENDED'],
            SupportTicket::STATUS['PENDING'],
            SupportTicket::STATUS['REJECTED'] => false,
            default => true
        };

        /* if ($currentStastus === SupportTicket::STATUS['ENDED']) {
             self::$errorMsg = 'Cannot reply to ended ticket !';
             return false;
         }

         if ($currentStastus === SupportTicket::STATUS['PENDING']) {
             $request->session()->flash('status',
                 ['type' => 'warning', 'message' => 'Cannot reply to pending ticket !']);

             return redirect()->route('dashboard');
         }

         if ($currentStastus === SupportTicket::STATUS['REJECTED']) {
             $request->session()->flash('status',
                 ['type' => 'warning', 'message' => 'Cannot reply to rejected ticket !']);

             return redirect()->route('dashboard');
         }*/
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return self::$errorMsg[$this->currentStatus];
    }
}
