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
        Schema::create('user_self_disclosures', function (Blueprint $table) {
            $table->id();

            $table->boolean('not_banned')->default(false);
            $table->boolean('accepted_inaccuracy')->default(false);
            $table->boolean('has_proof_of_identity')->default(false);
            $table->boolean('everyone_agrees')->default(false);

            $table->text('notes')->nullable();

            $table
                ->foreignUuid('global_user_id')
                ->constrained('users', 'global_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
        Schema::create('user_family_members', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('age');

            $table->morphs('familyable');

            $table
                ->foreignId('self_disclosure_id')
                ->constrained('user_self_disclosures')
                ->cascadeOnUpdate();
        });
        Schema::create('user_family_humans', function (Blueprint $table) {
            $table->id();
            $table->string('profession')->nullable();
            $table->boolean('knows_animals');
        });
        Schema::create('user_family_animals', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['dog', 'cat', 'other']);
            $table->boolean('good_with_animals');
            $table->boolean('castrated');
        });
        Schema::create('user_special_needs', function (Blueprint $table) {
            $table->id();
            $table->boolean('allergies');
            $table->boolean('handicapped');

            $table
                ->foreignId('self_disclosure_id')
                ->constrained('user_self_disclosures')
                ->cascadeOnUpdate();
        });
        Schema::create('user_care_eligibility', function (Blueprint $table) {
            $table->id();
            $table->boolean('animal_protection_experience');
            $table->boolean('can_cover_expenses');
            $table->boolean('can_cover_emergencies');
            $table->boolean('can_afford_insurance');
            $table->boolean('can_afford_castration');
            $table->string('substitute')->nullable();
            $table->integer('time_alone_daily');

            $table
                ->foreignId('self_disclosure_id')
                ->constrained('user_self_disclosures')
                ->cascadeOnUpdate();
        });
        Schema::create('user_homes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['apartment', 'house', 'other']);
            $table->boolean('own');
            $table->boolean('pets_allowed');
            $table->date('move_in_date');

            $table->integer('size');
            $table->integer('level');
            $table->enum('location', ['city', 'suburb', 'rural']);

            $table->boolean('garden');
            $table->integer('garden_size')->nullable();
            $table->boolean('garden_secure')->nullable();
            $table->boolean('garden_connected')->nullable();

            $table
                ->foreignId('self_disclosure_id')
                ->constrained('user_self_disclosures')
                ->cascadeOnUpdate();
        });
        Schema::create('user_experiences', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['work', 'pet', 'other']);
            $table->enum('animal_type', ['dog', 'cat', 'other']);
            $table->integer('years');

            $table
                ->foreignId('self_disclosure_id')
                ->constrained('user_self_disclosures')
                ->cascadeOnUpdate();
        });
        Schema::create('animal_specific_disclosures', function (
            Blueprint $table,
        ) {
            $table->id();

            $table->morphs('specifiable');
        });
        Schema::create('dog_specific_disclosures', function (Blueprint $table) {
            $table->id();

            $table->enum('habitat', ['home', 'garden', 'other']);

            $table->boolean('dog_school');
            $table->boolean('time_to_occupy');
            $table->enum('purpose', ['work', 'pet', 'breeding', 'other']);
        });
        Schema::create('cat_specific_disclosures', function (Blueprint $table) {
            $table->id();

            $table->enum('habitat', ['indoor', 'outdoor', 'both']);
            // Indoor only
            $table->boolean('house_secure')->nullable();

            // Outdoor only
            $table->string('sleeping_place')->nullable();
            $table->boolean('streets_safe')->nullable();
            $table->boolean('cat_flap_available')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_disclosures');
        Schema::dropIfExists('user_family_members');
        Schema::dropIfExists('user_family_humans');
        Schema::dropIfExists('user_family_animals');
        Schema::dropIfExists('user_care_eligibility');
        Schema::dropIfExists('user_homes');
        Schema::dropIfExists('user_experiences');
        Schema::dropIfExists('animal_specific_disclosures');
        Schema::dropIfExists('dog_specific_disclosures');
        Schema::dropIfExists('cat_specific_disclosures');
    }
};
