<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->unsignedSmallInteger('minutes');
            $table->boolean('is_favourite')->default(false);
            $table->timestamps();
        });

        // The database refuses minutes that make no sense
        DB::statement('ALTER TABLE recipes ADD CONSTRAINT recipes_minutes_positive CHECK (minutes > 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
