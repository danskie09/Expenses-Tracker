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
        Schema::create('financial_goal_weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('financial_goals')->onDelete('cascade');
            $table->integer('week_number')->notNull();
            $table->decimal('payable', 15, 2)->nullable();
            $table->decimal('collection', 15, 2)->nullable();
            $table->decimal('deficit', 15, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_goal_weeks');
    }
};
