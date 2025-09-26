<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('loan_id');
            $table->integer('email_template_id');
            $table->string('receiver_email');
            $table->string('sender_email');
            $table->string('subject');
            $table->text('body');
            $table->json('file_ids');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('sent_at')->useCurrent();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->integer('size')->default(0);
            $table->char('type', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
