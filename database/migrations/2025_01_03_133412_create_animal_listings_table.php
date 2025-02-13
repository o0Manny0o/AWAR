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
        Schema::create('listings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('description')->nullable();
            $table->string('excerpt', 255)->nullable();

            $table->timestamps();
        });

        Schema::create('listing_animals', function (Blueprint $table) {
            $table->id();
            $table->uuid('listing_id');
            $table->uuid('animal_id');

            $table->unique(['listing_id', 'animal_id']);

            $table
                ->foreign('listing_id')
                ->references('id')
                ->on('listings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('animal_id')
                ->references('id')
                ->on('animals')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
        Schema::dropIfExists('listing_animals');
    }
};
