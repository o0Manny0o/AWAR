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
        Schema::create('animal_families', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->boolean('siblings_grouped')->default(false);

            $table->string('name')->nullable();
            $table->text('bio')->nullable();
            $table->text('abstract')->nullable();

            $table
                ->foreignUuid('father_id')
                ->nullable()
                ->constrained('animals')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table
                ->foreignUuid('mother_id')
                ->nullable()
                ->constrained('animals')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::table('animals', function (Blueprint $table) {
            $table
                ->foreignUuid('animal_family_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropForeign(['animal_family_id']);
            $table->dropColumn('animal_family_id');
        });

        Schema::dropIfExists('animal_families');
    }
};
