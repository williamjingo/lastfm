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
        // used strings to maintain attributes' data types from last.fm API
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->bigInteger('listners');
            $table->text('image')->nullable();
            $table->text('url')->nullable();
            $table->string('mbid', 255)->nullable();
            $table->bigInteger('streamable')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
