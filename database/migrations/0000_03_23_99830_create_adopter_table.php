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
       /*  Schema::create('adopter', function (Blueprint $table) {
            $table->id();
            $table->string('adopter_first_name')->nullable();
            $table->string('adopter_last_name')->nullable();
            $table->string('adopter_address')->nullable();
            $table->string('adopter_type')->nullable();
            $table->string('adopter_type_name')->nullable();
            $table->string('adopter_email')->nullable();
            $table->string('adopter_phone')->nullable();
            //$table->string('flag_comandory')->nullable();
            //$table->unsignedBigInteger('commandory_id')->nullable();
            //$table->foreign('commandory_id')->references('id')->on('commandories')->onDelete('set null');
            $table->timestamps();
        }); */
        /* Schema::table('adopter', function (Blueprint $table) {
            $table->unsignedBigInteger('commandory_id')->nullable()->after('id');
            $table->foreign('commandory_id')->references('id')->on('commandories')->onDelete('set null');
        }); */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('adopter');
    }
};
