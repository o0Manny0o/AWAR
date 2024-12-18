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
        Schema::create('organisation_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');

            $table->boolean('public')->default(false);

            $table
                ->foreignUuid('organisation_id')
                ->constrained('organisations')
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
        Schema::dropIfExists('organisation_locations');
    }
};
