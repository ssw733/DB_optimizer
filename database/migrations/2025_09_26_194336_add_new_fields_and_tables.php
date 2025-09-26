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
        Schema::table('emails', function (Blueprint $table) {
            //Новое поле body_s3_path
            $table->string('body_s3_path');
        });

        Schema::create('emails_s3_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('email_id');
            $table->index('email_id');
            //Возможно каскадное удаление через таблицу emails здесь будет уместно
            //$table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');
            $table->string('path');
            $table->char('type', 5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            //
        });
    }
};
