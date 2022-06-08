<?php

use App\Models\SupportTicket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->index();
            $table->string('email', 255)->index();
            $table->char('phone_number', 10);
            $table->text('description');
            $table->char('reference_id', 50)->index();
            $table->tinyInteger('status')->default(SupportTicket::STATUS['PENDING'])->index();
            $table->tinyInteger('priority')->default(SupportTicket::PRIORITY['MEDIUM']);
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_ticket');
    }
};
