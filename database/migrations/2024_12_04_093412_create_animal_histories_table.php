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
        Schema::create('animal_histories', function (Blueprint $table) {
            $table->id();

            $table
                ->enum('type', ['initial', 'update', 'delete', 'restore'])
                ->default('initial');

            $table->uuid('global_user_id');

            $table
                ->foreignUuid('animal_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreign('global_user_id')
                ->references('global_id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_histories');
    }
};
