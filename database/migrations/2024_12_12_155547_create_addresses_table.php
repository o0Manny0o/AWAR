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
        Schema::create('countries', function (Blueprint $table) {
            $table->integer('code', 3)->primary();
            $table->string('name');
            $table->string('alpha', 2)->unique();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->string('street_address');
            $table->string('locality');
            $table->string('region')->nullable();
            $table->string('postal_code');

            $table
                ->foreignId('country_id')
                ->constrained('countries', 'code')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->uuidMorphs('addressable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('countries');
    }
};
