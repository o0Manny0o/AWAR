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
        Schema::create('organisation_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name");
            $table->string("type");
            $table->enum("status", ["draft", "pending", "approved", "rejected", "created"])->default('pending');
            $table->string("user_role");
            $table->boolean("registered");
            $table->string("street", 60)->nullable();
            $table->string("post_code", 10)->nullable();
            $table->string("city", 60)->nullable();
            $table->string("country", 60)->nullable();
            $table->string("subdomain", 60)->nullable();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();

            $table->softDeletes();

            $table->unique(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_applications');
    }
};
