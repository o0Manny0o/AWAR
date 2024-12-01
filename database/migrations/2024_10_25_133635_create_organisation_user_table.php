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
        Schema::create('organisation_users', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id');
            $table->uuid('global_user_id');

            $table->foreign('tenant_id')->references("id")->on("organisations")->onDelete("cascade")->onUpdate('cascade');
            $table->foreign('global_user_id')->references('global_id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['tenant_id', 'global_user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_users');
    }
};
