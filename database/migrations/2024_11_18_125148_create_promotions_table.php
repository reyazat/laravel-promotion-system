<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->boolean('is_available')->default(true);
            $table->json('avb_days')->nullable();
            $table->boolean('have_times')->default(false);
            $table->json('times')->nullable();
            $table->json('discount');
            $table->json('usage_limit')->nullable();
            $table->integer('limit_num')->nullable();
            $table->boolean('have_dates')->default(false);
            $table->json('dates')->nullable();
            $table->unsignedInteger('usage_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
