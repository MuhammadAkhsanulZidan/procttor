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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('project_name');
            $table->string('image')->nullable();
            $table->date('project_plan_startDate');
            $table->date('project_plan_endDate');
            $table->date('project_real_startDate');
            $table->date('project_real_endDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
