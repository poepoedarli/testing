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
        Schema::create('dca_ma_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ref_id');
            $table->longText('img_path');
            $table->enum('ai_result', ['G', 'NG']);
            $table->tinyText('ai_code')->nullable();

            $table->enum('label_result', ['G', 'NG'])->nullable();
            $table->tinyText('label_code')->nullable();
            $table->tinyText('remarks')->nullable();

            $table->timestamps();
            $table->foreign('ref_id')->references('id')->on('dca_ma_references');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dca_ma_results');
    }
};
