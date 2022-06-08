<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        User::create([
            'name' => 'test',
            'email' => 'test@mail.co',
            'password' => Hash::make('password'),
            'role_id' => User::ROLES['SUPPORT_AGENT'],
        ]);

        $this->call([
            SupportTicketSeeder::class,
        ]);

        $tickets = SupportTicket::whereIn('status', [
            SupportTicket::STATUS['REPLIED'],
        ])->get();

        $tickets->each(function ($ticket) {
            $replies = Reply::factory()->count(mt_rand(1, 5))->create();
            $ticket->replies()->attach($replies->pluck('id')->all());
        });
    }
}
