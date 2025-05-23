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
        Schema::create('animal_changes', function (Blueprint $table) {
            $table->id();

            $table->string('field');
            $table->string('value')->nullable();

            $table
                ->foreignId('animal_history_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamp('created_at')->useCurrent();

            $table->unique(['animal_history_id', 'field']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_changes');
    }
};
