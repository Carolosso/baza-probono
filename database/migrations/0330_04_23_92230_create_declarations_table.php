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
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('child_id')->nullable();
            $table->foreign('child_id')->references('id')->on('children')->onDelete('set null');

            $table->unsignedBigInteger('adopter_id')->nullable();
            $table->foreign('adopter_id')->references('id')->on('adopters')->onDelete('set null');

            $table->unsignedBigInteger('assistant_id')->nullable();
            $table->foreign('assistant_id')->references('id')->on('assistants')->onDelete('set null');

            $table->unsignedBigInteger('commandory_id')->nullable();
            $table->foreign('commandory_id')->references('id')->on('commandories')->onDelete('set null');

            $table->string('evidenceNumber')->nullable();
            $table->string('typeOfAdoption')->nullable();
            $table->integer('lengthOfAdoption')->nullable();
            $table->date('adoptionStartDate')->nullable();
            $table->date('adoptionEndDate')->nullable();
            $table->integer('remainingDaysOfAdoption')->nullable();
            $table->string('status')->nullable();
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
