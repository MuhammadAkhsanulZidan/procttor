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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('project_id');
            $table->string('activity_name');
            $table->string('activity_url')->nullable();
            $table->date('activity_plan_startDate');
            $table->date('activity_plan_endDate');
            $table->date('activity_real_startDate')->nullable();
            $table->date('activity_real_endDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
