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
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->nullable(false);
            $table->tinyText('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('ref_no', 50)->nullable();
            $table->json('web_page_screenshots')->nullable();
            $table->tinyText('application_flow')->nullable();
            $table->mediumText('documentation_link')->nullable();
            $table->unsignedSmallInteger('host_port')->default(0);
            $table->unsignedSmallInteger('container_port')->default(0);
            $table->unsignedMediumInteger('timeout')->default(0);
            $table->unsignedSmallInteger('cpu_limit')->default(0);
            $table->unsignedSmallInteger('gpu_limit')->default(0);
            $table->unsignedSmallInteger('memory_limit')->default(0);
            $table->json('container_info')->nullable();
            $table->enum('state', ['creating', 'running', 'stopped', 'restarting'])->default('creating');
            $table->unsignedBigInteger('creator_id');
            $table->boolean('status')->default(true);
            $table->boolean('is_cloned')->default(false);
            $table->unsignedBigInteger('parent_app_id')->default(0);
            $table->unsignedBigInteger('service_id')->nullable();
            //$table->string('folder_name', 50)->nullable()->comment("The name of the folder where the application's flow designs exists. views/applications/flow_designs/{folder_name}");
            $table->string('flow_ref_no')->nullable();

            $table->tinyText('remarks')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
