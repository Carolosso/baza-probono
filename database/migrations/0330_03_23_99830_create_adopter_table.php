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
        Schema::create('adopters', function (Blueprint $table) {
            $table->id();
            $table->string('adopter_first_name')->nullable();
            $table->string('adopter_last_name')->nullable();
            $table->string('adopter_address')->nullable();
            $table->string('adopter_type')->nullable();
            $table->string('adopter_type_name')->nullable();
            $table->string('adopter_email')->nullable();
            $table->string('adopter_phone')->nullable();
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('adopter');
    }
};
