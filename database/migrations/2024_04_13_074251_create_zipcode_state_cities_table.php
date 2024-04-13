<?php

use Brick\Math\BigInteger;
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
        Schema::create('zipcode_state_cities', function (Blueprint $table) {
            $table->id();
            $table->string('PostOfficeName');
            $table->string('Pincode');
            $table->string('City');
            $table->string('District');
            $table->string('State');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zipcode_state_cities');
    }
};
