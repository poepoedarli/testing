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
        Schema::create('backend_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('action_name', 50);
            $table->unsignedBigInteger('application_id');
            $table->json('payload')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('mark_as_done')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backend_jobs');
    }
};
