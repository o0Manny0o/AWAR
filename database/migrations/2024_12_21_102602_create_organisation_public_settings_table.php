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
        Schema::create('organisation_public_settings', function (
            Blueprint $table,
        ) {
            $table->id();

            $table->string('name');
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();

            $table
                ->foreignUuid('organisation_id')
                ->constrained('organisations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_public_settings');
    }
};
