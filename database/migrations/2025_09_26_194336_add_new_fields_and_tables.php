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
            $table->string('body_s3_path')->nullable();
        });

        Schema::table('files', function (Blueprint $table) {
            //Новое поле body_s3_path
            $table->integer('email_id')->nullable();
            $table->integer('s3_path')->nullable();
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
