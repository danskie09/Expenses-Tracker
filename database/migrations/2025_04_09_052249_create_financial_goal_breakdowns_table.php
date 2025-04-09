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
        Schema::create('financial_goal_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('week_id')->constrained('financial_goal_weeks')->onDelete('cascade');
            $table->string('description', 100)->notNull();
            $table->decimal('amount', 15, 2)->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_goal_breakdowns');
    }
};