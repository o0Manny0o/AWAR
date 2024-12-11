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
        Schema::create('animals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->date('date_of_birth');

            $table->text('bio')->nullable();
            $table->text('abstract')->nullable();

            $table->enum('sex', ['male', 'female'])->nullable();

            $table->timestamp('published_at')->nullable();

            $table->morphs('animalable');

            $table
                ->foreignUuid('organisation_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
