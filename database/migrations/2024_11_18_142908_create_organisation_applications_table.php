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
            $table->id();
            $table->string("name");
            $table->string("type");
            $table->enum("status", ["pending", "approved", "rejected", "created"])->default('pending');
            $table->string("user_role");
            $table->boolean("registered");
            $table->string("street", 60);
            $table->string("post_code", 10);
            $table->string("city", 60);
            $table->string("country", 60);
            $table->string("subdomain", 60);
            $table->foreignId("user_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
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
