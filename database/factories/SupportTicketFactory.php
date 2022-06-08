<?php

namespace Database\Factories;

use App\Models\SupportTicket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone_number' => '071'.$this->faker->randomNumber(7, true),
            'description' => $this->faker->paragraphs(10, true),
            'reference_id' => Str::uuid(),
            'status' => $this->faker->randomElement(SupportTicket::STATUS),
            'priority' => $this->faker->randomElement(SupportTicket::PRIORITY),
        ];
    }
}
