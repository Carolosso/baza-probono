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
        /* Schema::create('assistants', function (Blueprint $table) {
            $table->id();
            $table->string('assitant_first_name')->nullable();
            $table->string('assistant_last_name')->nullable();
            $table->string('others')->nullable();
            $table->timestamps();
        });  */
        // Schema::table('assistants', function (Blueprint $table) {
        //     $table->unsignedBigInteger('commandory_id')->nullable();
        //     $table->foreign('commandory_id')->references('id')->on('commandories')->onDelete('set null');
        // }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('adopter');
    }
};
