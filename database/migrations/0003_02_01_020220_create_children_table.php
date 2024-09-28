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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('age')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('country')->nullable();
            $table->date('adoption_date')->nullable();
            $table->integer('length_of_adoption')->nullable();
            $table->string('adopter_first_name')->nullable();
            $table->string('adopter_last_name')->nullable();
            $table->string('flag')->nullable();
            $table->string('flag_comandory')->nullable();
            $table->string('image_url')->nullable();
            $table->string('one_time_pay')->nullable();
            $table->string('first_pay')->nullable();
            $table->string('second_pay')->nullable();
            $table->string('third_pay')->nullable();
            $table->string('forth_pay')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
