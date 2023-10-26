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
        Schema::create('datasets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('data_path');
            $table->boolean('is_public')->default(false);
            $table->enum('type', ['Structured Datasets', 'Text Datasets', 'Image Datasets', 'Audio Datasets', 'Time Series Datasets'])->default('Image Datasets');

            $table->json('tags')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->unsignedBigInteger('department_id');
            $table->longText('descriptions')->nullable();

            $table->timestamps();
            $table->softDeletes();

            //$table->unsignedBigInteger('dataset_template_id');
            //$table->foreign('dataset_template_id')->references('id')->on('dataset_templates');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasets');
    }
};
