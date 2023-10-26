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
        Schema::create('operation_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('route_name', 50);
            $table->string('title', 50);
            $table->json('parameters')->nullable();
            $table->foreign('application_id')->references('id')->on('applications');
            $table->foreign('parent_id')->references('id')->on('operation_pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_pages');
    }
};
